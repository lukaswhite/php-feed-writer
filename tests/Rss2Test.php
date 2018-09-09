<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Entities\Media\Media;
use Lukaswhite\FeedWriter\RSS2;
use Lukaswhite\RSSWriter\Feed;

class Rss2Test extends TestCase
{
    public function testCreatingFeed( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );
        $this->assertTrue( $feed->getDocument( )->formatOutput );

        $channel = $feed->addChannel( );

        $channelPubDate = new \DateTime( '2018-09-04 09:30' );
        $channelLastBuildDate = new \DateTime( '2018-09-06 17:30' );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' )
            ->pubDate( $channelPubDate )
            ->lastBuildDate( $channelLastBuildDate )
            ->language( 'en-US' )
            ->copyright( 'Copyright Example Org' )
            ->addAtomLink( 'http://example.com/atom.xml', true )
            ->addPubSubHubbubLink( 'http://pubsubhubbub.appspot.com' )
            ->generator( 'Feed Writer' )
            ->ttl( 60 )
            ->categories( 'one', 'two', 'three' )
            ->addCategory( 'four' )
            ->addImage( )
                ->url( 'http://example.com/image.jpeg' )
                ->link( 'http://example.com' )
                ->title( 'An example image')
                ->width( 200 )
                ->height( 150 );

        $item1 = $channel->addItem( );

        $item1->title( 'Item 1 title' )
            ->description( 'A description of the first item' )
            ->link( 'http://example.com/blog/post-1.html' )
            ->pubDate( new \DateTime( '2018-09-07 09:30' ) )
            ->guid( 'http://example.com/blog/post-1.html', true );

        $enclosure = $item1->addEnclosure( );
        $enclosure->url( 'http://example.com/audio.mp3' )
            ->length( 1000 )
            ->type( 'audio/mpeg' );

        $item2 = $channel->addItem( );

        $item2->title( 'Item 2 title' )
            ->description( 'A description of the second item' )
            ->link( 'http://example.com/blog/post-2.html' )
            ->pubDate( new \DateTime( '2018-09-08 09:30' ) )
            ->guid( 'http://example.com/blog/post-2.html' );

        $this->assertTrue( is_array( $channel->getItems( ) ) );
        $this->assertEquals( 2, count( $channel->getItems( ) ) );

        //print( $feed->toString( ) );

        $xml = $feed->build( );
        $this->assertEquals( 'rss', $xml->documentElement->tagName );

        $doc = new \DOMDocument( );
        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);
        $channels = $xpath->query( '/rss/channel' );
        $this->assertEquals( 1, $channels->length );

        $titles = $xpath->query( '/rss/channel/title' );
        $this->assertEquals( 1, $titles->length );
        $this->assertEquals( 'Channel title', $titles[ 0 ]->textContent );

        $descriptions = $xpath->query( '/rss/channel/description' );
        $this->assertEquals( 1, $descriptions->length );
        $this->assertEquals( 'A description of the channel', $descriptions[ 0 ]->textContent );
        $this->assertTrue( strpos( $feed->toString( ), '<description><![CDATA[' ) > -1 );

        $languages = $xpath->query( '/rss/channel/language' );
        $this->assertEquals( 1, $languages->length );
        $this->assertEquals( 'en-US', $languages[ 0 ]->textContent );

        $copyrights = $xpath->query( '/rss/channel/copyright' );
        $this->assertEquals( 1, $copyrights->length );
        $this->assertEquals( 'Copyright Example Org', $copyrights[ 0 ]->textContent );

        $lastBuildDates = $xpath->query( '/rss/channel/lastBuildDate' );
        $this->assertEquals( 1, $lastBuildDates->length );
        $this->assertEquals(
            $channelLastBuildDate->format( 'Y-m-d' ),
            ( new \DateTime( $lastBuildDates[ 0 ]->textContent ) )->format( 'Y-m-d' )
        );

        $pubDates = $xpath->query( '/rss/channel/pubDate' );
        $this->assertEquals( 1, $pubDates->length );
        $this->assertEquals(
            $channelPubDate->format( 'Y-m-d' ),
            ( new \DateTime( $pubDates[ 0 ]->textContent ) )->format( 'Y-m-d' )
        );

        $generators = $xpath->query( '/rss/channel/generator' );
        $this->assertEquals( 1, $generators->length );
        $this->assertEquals( 'Feed Writer', $generators[ 0 ]->textContent );

        $ttls = $xpath->query( '/rss/channel/ttl' );
        $this->assertEquals( 1, $ttls->length );
        $this->assertEquals( '60', $ttls[ 0 ]->textContent );

        $atomLinks = $xpath->query( '/rss/channel/atom:link' );
        $this->assertEquals( 2, $atomLinks->length );
        $atomLinkAttributes = $this->getAttributesOfElementNamed( 'atom:link', $feed->toString( ) );
        $this->assertArrayHasKey( 'href', $atomLinkAttributes );
        $this->assertEquals( 'http://example.com/atom.xml', $atomLinkAttributes[ 'href' ] );
        $this->assertArrayHasKey( 'rel', $atomLinkAttributes );
        $this->assertEquals( 'self', $atomLinkAttributes[ 'rel' ] );
        $this->assertArrayHasKey( 'type', $atomLinkAttributes );
        $this->assertEquals( 'application/atom+xml', $atomLinkAttributes[ 'type' ] );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:atom="http://www.w3.org/2005/Atom' ) > -1 );

        $items = $xpath->query( '/rss/channel/item' );
        $this->assertEquals( 2, $items->length );

        $firstItemTitles = $xpath->query( '/rss/channel/item[1]/title' );
        $this->assertEquals( 1, $firstItemTitles->length );
        $this->assertEquals( 'Item 1 title', $firstItemTitles[ 0 ]->textContent );
        $secondItemTitles = $xpath->query( '/rss/channel/item[2]/title' );
        $this->assertEquals( 1, $secondItemTitles->length );
        $this->assertEquals( 'Item 2 title', $secondItemTitles[ 0 ]->textContent );

        $firstItemDescriptions = $xpath->query( '/rss/channel/item[1]/description' );
        $this->assertEquals( 1, $firstItemDescriptions->length );
        $this->assertEquals( 'A description of the first item', $firstItemDescriptions[ 0 ]->textContent );

        $enclosures = $xpath->query( '/rss/channel/item[1]/enclosure' );
        $this->assertEquals( 1, $enclosures->length );
        $enclosureAttributes = $this->getAttributesOfElementNamed( 'enclosure', $feed->toString( ) );
        $this->assertArrayHasKey( 'url', $enclosureAttributes );
        $this->assertEquals( 'http://example.com/audio.mp3', $enclosureAttributes[ 'url' ] );
        $this->assertArrayHasKey( 'length', $enclosureAttributes );
        $this->assertEquals( '1000', $enclosureAttributes[ 'length' ] );
        $this->assertArrayHasKey( 'type', $enclosureAttributes );
        $this->assertEquals( 'audio/mpeg', $enclosureAttributes[ 'type' ] );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/image' )->length );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/image/url' )->length );
        $this->assertEquals(
            'http://example.com/image.jpeg',
            $xpath->query( '/rss/channel/image/url' )[ 0 ]->textContent
        );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/image/link' )->length );
        $this->assertEquals(
            'http://example.com',
            $xpath->query( '/rss/channel/image/link' )[ 0 ]->textContent
        );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/image/title' )->length );
        $this->assertEquals(
            'An example image',
            $xpath->query( '/rss/channel/image/title' )[ 0 ]->textContent
        );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/image/width' )->length );
        $this->assertEquals(
            '200',
            $xpath->query( '/rss/channel/image/width' )[ 0 ]->textContent
        );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/image/height' )->length );
        $this->assertEquals(
            '150',
            $xpath->query( '/rss/channel/image/height' )[ 0 ]->textContent
        );



        $this->assertEquals( $feed->toString( ), ( string ) $feed );
    }

    public function testIncludingXslStylesheet( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->xslStylesheet( '/feed.xsl' );
        $result = $feed->build( )->saveXML( );
        $this->assertTrue(
            strpos(
                $result,
                '<?xml-stylesheet type="text/xsl" href="/feed.xsl"?>'
            ) > -1
        );
    }

    public function testAddingMedia( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        //$feed->registerNamespace( 'media', 'http://search.yahoo.com/mrss/' );
        $feed->registerAtomNamespace( );

        $channel = $feed->addChannel( );

        $channelPubDate = new \DateTime( '2018-09-04 09:30' );
        $channelLastBuildDate = new \DateTime( '2018-09-06 17:30' );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' )
            ->pubDate( $channelPubDate )
            ->lastBuildDate( $channelLastBuildDate )
            ->language( 'en-US' )
            ->copyright( 'Copyright Example Org' )
            ->addLink( 'atom:link', 'http://example.com', 'self', 'application/atom+xml' )
            ->categories( 'one', 'two', 'three' )
            ->addCategory( 'four' );


        $item = $channel->addItem( );

        $item->title( 'Rocking Webmonkey Garage Band' )
            ->description( 'The best ever garage band on the Internet.' )
            ->link( 'http://www.webmonkey.com/ourband.html' )
            ->guid( 'http://www.webmonkey.com/ourband.html', true );


        $media = $item->addMedia( )
                ->url( 'http://www.webmonkey.com/monkeyrock.mpg' )
                ->fileSize( 2471632 )
                ->type( 'video/mpeg' )
                ->width( 320 )
                ->height( 240 )
                ->duration( 147 )
                ->medium( 'video' )
                ->expression( 'full' )
                ->bitrate( 128 )
                ->framerate( 24 )
                ->isDefault( )
                //->player( 'http://www.somevideouploadsite/webmonkey.html' )
                ->title( 'The Webmonkey Band "Monkey Rock"' )
                ->description( 'See Rocking Webmonkey Garage Band playing our classic song "Monkey Rock" to a sold-out audience at the Fillmore Auditorium.' )
                ->thumbnail(
                    ( new \Lukaswhite\FeedWriter\Entities\Media\Thumbnail( $feed ) )
                        ->url( 'http://www.webmonkey.com/images/monkeyrock-thumb.jpg' )
                        ->width( 145 )
                        ->height( 98 )
                );


        $rendered = $feed->build( )->saveXml( );

        $this->assertTrue( strpos( $rendered, 'xmlns:media="http://search.yahoo.com/mrss' ) > -1 );

        $mediaAttributes = $this->getAttributesOfElementNamed( 'media:content', $rendered, [ 'media' => 'http://search.yahoo.com/mrss/' ] );

        $this->assertArrayHasKey( 'url', $mediaAttributes );
        $this->assertEquals( 'http://www.webmonkey.com/monkeyrock.mpg', $mediaAttributes[ 'url' ] );
        $this->assertArrayHasKey( 'type', $mediaAttributes );
        $this->assertEquals( 'video/mpeg', $mediaAttributes[ 'type' ] );
        $this->assertArrayHasKey( 'medium', $mediaAttributes );
        $this->assertEquals( 'video', $mediaAttributes[ 'medium' ] );
        $this->assertArrayHasKey( 'fileSize', $mediaAttributes );
        $this->assertEquals( '2471632', $mediaAttributes[ 'fileSize' ] );
        $this->assertArrayHasKey( 'width', $mediaAttributes );
        $this->assertEquals( '320', $mediaAttributes[ 'width' ] );
        $this->assertArrayHasKey( 'height', $mediaAttributes );
        $this->assertEquals( '240', $mediaAttributes[ 'height' ] );
        $this->assertArrayHasKey( 'duration', $mediaAttributes );
        $this->assertEquals( '147', $mediaAttributes[ 'duration' ] );
        $this->assertArrayHasKey( 'bitrate', $mediaAttributes );
        $this->assertEquals( '128', $mediaAttributes[ 'bitrate' ] );
        $this->assertArrayHasKey( 'framerate', $mediaAttributes );
        $this->assertEquals( '24', $mediaAttributes[ 'framerate' ] );
        $this->assertArrayHasKey( 'expression', $mediaAttributes );
        $this->assertEquals( 'full', $mediaAttributes[ 'expression' ] );
        $this->assertArrayHasKey( 'isDefault', $mediaAttributes );
        $this->assertEquals( 'true', $mediaAttributes[ 'isDefault' ] );

        //print( $feed->build( )->saveXML( ) );

    }

    public function testMediaGroups( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );

        $channel = $feed->addChannel( );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $item = $channel->addItem( );

        $item->title( 'Rocking Webmonkey Garage Band' )
            ->description( 'The best ever garage band on the Internet.' )
            ->link( 'http://www.webmonkey.com/ourband.html' )
            ->guid( 'http://www.webmonkey.com/ourband.html', true );

        $mediaGroup = $item->addMediaGroup( );

        $mediaGroup->addMedia( )
            ->url( 'http://www.webmonkey.com/monkeyrock.mpg' )
            ->fileSize( 2471632 )
            ->type( Media::VIDEO );

        $mediaGroup->addMedia( )
            ->url( 'http://www.webmonkey.com/monkeyrock.mpeg' )
            ->fileSize( 1253 )
            ->type( Media::IMAGE );

        $doc = new \DOMDocument( );
        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);


        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/media:group' )->length );
        $this->assertEquals( 2, $xpath->query( '/rss/channel/item[1]/media:group[1]/media:content' )->length );
        //$this->assertEquals( 'Yes', $xpath->query( '/rss/channel/itunes:block' )[ 0 ]->textContent );

    }

    public function testMisc( )
    {
        $feed = new RSS2( );
        $feed->registerDublinCoreNamespace( );
        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:media="http://purl.org/dc/elements/1.1' ) > -1 );
    }

    public function testTextInput( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );

        $channel = $feed->addChannel( );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $channel->addTextInput( )
            ->name( 'Text input name' )
            ->description( 'a desc of the text input' )
            ->title( 'text input title' )
            ->link( 'http://example.com/script.cgi' );

        $doc = new \DOMDocument( );
        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/textInput' )->length );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/textInput/title' )->length );
        $this->assertEquals( 'text input title', $xpath->query( '/rss/channel/textInput/title' )[ 0 ]->textContent );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/textInput/description' )->length );
        $this->assertEquals( 'a desc of the text input', $xpath->query( '/rss/channel/textInput/description' )[ 0 ]->textContent );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/textInput/name' )->length );
        $this->assertEquals( 'Text input name', $xpath->query( '/rss/channel/textInput/name' )[ 0 ]->textContent );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/textInput/link' )->length );
        $this->assertEquals( 'http://example.com/script.cgi', $xpath->query( '/rss/channel/textInput/link' )[ 0 ]->textContent );


    }

    /**
     * @expectedException \Lukaswhite\FeedWriter\Exceptions\InvalidMediumException
     */
    public function testThatAnExceptionIsThrownIfMediumIsInvalid( )
    {
        $media = new \Lukaswhite\FeedWriter\Entities\Media\Media( new RSS2( ) );
        $media->medium( 'dance' );
    }

    /**
     * @expectedException \Lukaswhite\FeedWriter\Exceptions\InvalidExpressionException
     */
    public function testThatAnExceptionIsThrownIfExpressionIsInvalid( )
    {
        $media = new \Lukaswhite\FeedWriter\Entities\Media\Media( new RSS2( ) );
        $media->expression( 'e=mc2' );
    }
}