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
            ->skipDays( 'Saturday', 'Sunday' )
            ->skipHours( 0, 1, 2, 3, 4 )
            ->webmaster( 'webmaster@example.com' )
            ->managingEditor( 'editor@example.com (the editor)' )
            ->rating( '(PICS-1.1 "http://www.rsac.org/ratingsv01.html" l by "webmaster@example.com" on "2007.01.29T10:09-0800" r (n 0 s 0 v 0 l 0))' )
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
            ->guid( 'http://example.com/blog/post-1.html', true )
            ->encodedContent( '<p>The content of the item</p>' )
            ->author( 'jbb@dallas.example.com (Joe Bob Briggs)' )
            ->addCategory( 'one' )
            ->addCategory( 'two', 'http://example.com/categories' );

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

        $webmasters = $xpath->query( '/rss/channel/webMaster' );
        $this->assertEquals( 1, $webmasters->length );
        $this->assertEquals( 'webmaster@example.com', $webmasters[ 0 ]->textContent );

        $managingEditors = $xpath->query( '/rss/channel/managingEditor' );
        $this->assertEquals( 1, $managingEditors->length );
        $this->assertEquals( 'editor@example.com (the editor)', $managingEditors[ 0 ]->textContent );

        $ratings = $xpath->query( '/rss/channel/rating' );
        $this->assertEquals( 1, $ratings->length );
        $this->assertEquals(
            '(PICS-1.1 "http://www.rsac.org/ratingsv01.html" l by "webmaster@example.com" on "2007.01.29T10:09-0800" r (n 0 s 0 v 0 l 0))',
            $ratings[ 0 ]->textContent
        );

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

        $this->assertEquals( 1, $xpath->query( '/rss/channel/skipDays' )->length );
        $this->assertEquals( 2, $xpath->query( '/rss/channel/skipDays/day' )->length );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/skipHours' )->length );
        $this->assertEquals( 5, $xpath->query( '/rss/channel/skipHours/hour' )->length );

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

        $firstItemEncodedContents = $xpath->query( '/rss/channel/item[1]/content:encoded' );
        $this->assertEquals( 1, $firstItemEncodedContents->length );
        $this->assertEquals( '<p>The content of the item</p>', $firstItemEncodedContents[ 0 ]->textContent );
        $this->assertTrue( strpos( $feed->toString( ), '<content:encoded><![CDATA[' ) > -1 );

        $firstItemAuthors = $xpath->query( '/rss/channel/item[1]/author' );
        $this->assertEquals( 1, $firstItemAuthors->length );
        $this->assertEquals( 'jbb@dallas.example.com (Joe Bob Briggs)', $firstItemAuthors[ 0 ]->textContent );

        $firstItemcategories = $xpath->query( '/rss/channel/item[1]/category' );
        $this->assertEquals( 2, $firstItemcategories->length );
        $this->assertEquals( 'one', $firstItemcategories[ 0 ]->textContent );
        $this->assertEquals( 'two', $firstItemcategories[ 1 ]->textContent );

        $firstItemPubDates = $xpath->query( '/rss/channel/item[1]/pubDate' );
        $this->assertEquals( 1, $firstItemPubDates->length );
        $this->assertEquals( 'Fri, 07 Sep 2018 09:30:00 +0000', $firstItemPubDates[ 0 ]->textContent );

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

    public function testMisc( )
    {
        $feed = new RSS2( );
        $feed->registerDublinCoreNamespace( );
        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:media="http://purl.org/dc/elements/1.1' ) > -1 );
        $feed->registerGeoRSSNamespace( );
        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

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

    public function testCloud( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );

        $channel = $feed->addChannel( );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $channel->addCloud( )
            ->domain( 'server.example.com' )
            ->path( '/rpc' )
            ->port( 80 )
            ->protocol( 'xml-rpc' )
            ->registerProcedure( 'cloud.notify' );

        $doc = new \DOMDocument( );
        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/cloud' )->length );

        $attributes = $this->getAttributesOfElementNamed( 'cloud', $feed->toString( ) );
        $this->assertArrayHasKey( 'domain', $attributes );
        $this->assertEquals( 'server.example.com', $attributes[ 'domain' ] );
        $this->assertArrayHasKey( 'path', $attributes );
        $this->assertEquals( '/rpc', $attributes[ 'path' ] );
        $this->assertArrayHasKey( 'port', $attributes );
        $this->assertEquals( '80', $attributes[ 'port' ] );
        $this->assertArrayHasKey( 'protocol', $attributes );
        $this->assertEquals( 'xml-rpc', $attributes[ 'protocol' ] );
        $this->assertArrayHasKey( 'registerProcedure', $attributes );
        $this->assertEquals( 'cloud.notify', $attributes[ 'registerProcedure' ] );


    }

    public function testThatHTMLDescriptionsAreAutomaticallyEncoded( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );
        $this->assertTrue( $feed->getDocument( )->formatOutput );

        $channel = $feed->addChannel( );

        $channelPubDate = new \DateTime( '2018-09-04 09:30' );
        $channelLastBuildDate = new \DateTime( '2018-09-06 17:30' );

        $channel->title( 'Channel title' )
            ->description( 'A description of the <strong>channel</strong>' );
        $this->assertTrue( strpos( $feed->toString( ), '<description><![CDATA[' ) > -1 );
    }

    public function testCanSpecifyToEncodeDescription( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );
        $this->assertTrue( $feed->getDocument( )->formatOutput );

        $channel = $feed->addChannel( );

        $channelPubDate = new \DateTime( '2018-09-04 09:30' );
        $channelLastBuildDate = new \DateTime( '2018-09-06 17:30' );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel', true );
        $this->assertTrue( strpos( $feed->toString( ), '<description><![CDATA[' ) > -1 );
    }

    public function testAddingCustomElements( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->registerNamespace( 'foo', 'http://foo.com' );
        $channel = $feed->addChannel( );
        $bar = $channel->addElement( 'foo:bar', 'just a test', [ 'x' => 1, 'y' => 2 ] );

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/foo:bar' )->length );
        $this->assertEquals(
            'just a test',
            $xpath->query( '/rss/channel/foo:bar' )[ 0 ]->textContent
        );

        $attributes = $this->getAttributesOfElementNamed( 'foo:bar', $feed->toString( ) );
        $this->assertArrayHasKey( 'x', $attributes );
        $this->assertEquals( '1', $attributes[ 'x' ] );
        $this->assertArrayHasKey( 'y', $attributes );
        $this->assertEquals( '2', $attributes[ 'y' ] );
    }

    public function testAddingCustomElementsWithChildren( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->registerNamespace( 'library', 'http://example.com/library' );
        $channel = $feed->addChannel( );

        $item = $channel->addItem( );

        $book = $item->addElement( 'library:book', null, [ ] );
        $book->addElement( 'title', 'A Book' );
        $book->addElement( 'isbn', '978-3-16-148410-0' );


        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/library:book' )->length );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/library:book/title' )->length );
        $this->assertEquals(
            'A Book',
            $xpath->query( '/rss/channel/item[1]/library:book/title' )[ 0 ]->textContent
        );
        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/library:book/isbn' )->length );
        $this->assertEquals(
            '978-3-16-148410-0',
            $xpath->query( '/rss/channel/item[1]/library:book/isbn' )[ 0 ]->textContent
        );
    }

}