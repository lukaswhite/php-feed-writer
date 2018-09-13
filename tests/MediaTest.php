<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Entities\Media\Credit;
use Lukaswhite\FeedWriter\Entities\Media\Media;
use Lukaswhite\FeedWriter\Entities\Media\Price;
use Lukaswhite\FeedWriter\RSS2;
use Lukaswhite\RSSWriter\Feed;

class MediaTest extends TestCase
{
    public function testAddingMedia( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        //$feed->registerNamespace( 'media', 'http://search.yahoo.com/mrss/' );
        $feed->registerAtomNamespace( );

        $feed->prettyPrint();

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
                ->medium( Media::VIDEO )
                ->expression( Media::FULL )
                ->bitrate( 128 )
                ->framerate( 24 )
                ->isDefault( )
                ->player( 'http://www.somevideouploadsite/webmonkey.html' )
                ->title( 'The Webmonkey Band "Monkey Rock"' )
                ->description( 'See Rocking Webmonkey Garage Band playing our classic song "Monkey Rock" to a sold-out audience at the <a href="http://www.fillmoreauditorium.org/">Fillmore Auditorium</a>.', 'html' )
                ->keywords( 'monkeys', 'music', 'rock' )
                ->hash( 'dfdec888b72151965a34b4b59031290a', 'md5' )
                ->comments(
                    'This is great',
                    'I like this'
                );

        $media->addCredit( )
            ->name( 'John Doe')
            ->role( 'composer' )
            ->scheme( 'urn:ebu' );

        $media->addThumbnail( )
            ->url( 'http://www.webmonkey.com/images/monkeyrock-thumb.jpg' )
            ->width( 145 )
            ->height( 98 )
            ->time( '12:34' );

        $media->addText( )
            ->content( 'Oh, say, can you see' )
            ->language( 'en' )
            ->start( '00:00:03.000' )
            ->end( '00:00:10.000' );

        $media->addText( )
            ->content( 'By the dawn\'s early <strong>light</strong>', 'html' )
            ->language( 'en' )
            ->start( '00:00:10.000' )
            ->end( '00:00:17.000' );

        $media->addPrice( )
            ->price( 19.99 )
            ->type( Price::PACKAGE )
            ->info( 'http://www.dummy.jp/package_info.html' )
            ->currency( 'EUR' );

        $media->addScene( )
            ->title( 'sceneTitle1' )
            ->description( 'sceneDesc1' )
            ->startTime( '00:15' )
            ->endTime( '00:45' );

        $media->addScene( )
            ->title( 'sceneTitle2' )
            ->description( 'sceneDesc2' )
            ->startTime( '00:57' )
            ->endTime( '01:45' );

        $media->addRestriction( )->allow( )->byCountry( 'au' );
        $media->addRestriction( )->onSharing( )->deny( );
        $media->addRestriction( )->byUri( 'http://example.com' ); // deny is the default

        $media->addBacklink( 'http://www.backlink1.com' )
            ->addBacklink( 'http://www.backlink2.com' )
            ->addBacklink( 'http://www.backlink3.com' );

        $media->addRating( 'adult', 'urn:simple' )
            ->addRating( 'r (cz 1 lz 1 nz 1 oz 1 vz 1)','urn:icra' )
            ->addRating( 'a-rating' );

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

        //print $feed;

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/media:content/media:description' )->length );
        $this->assertEquals(
            'See Rocking Webmonkey Garage Band playing our classic song "Monkey Rock" to a sold-out audience at the <a href="http://www.fillmoreauditorium.org/">Fillmore Auditorium</a>.',
            $xpath->query( '/rss/channel/item[1]/media:content/media:description' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/media:content/media:keywords' )->length );
        $this->assertEquals(
            'monkeys, music, rock',
            $xpath->query( '/rss/channel/item[1]/media:content/media:keywords' )[ 0 ]->textContent
        );

        $this->assertEquals(
            'type',
            $xpath->query( '/rss/channel/item[1]/media:content/media:description' )[ 0 ]->attributes[ 0 ]->name
        );
        $this->assertEquals(
            'html',
            $xpath->query( '/rss/channel/item[1]/media:content/media:description' )[ 0 ]->attributes[ 0 ]->value
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/media:content/media:hash' )->length );
        $this->assertEquals(
            'dfdec888b72151965a34b4b59031290a',
            $xpath->query( '/rss/channel/item[1]/media:content/media:hash' )[ 0 ]->textContent
        );
        $this->assertEquals(
            'algo',
            $xpath->query( '/rss/channel/item[1]/media:content/media:hash' )[ 0 ]->attributes[ 0 ]->name
        );
        $this->assertEquals(
            'md5',
            $xpath->query( '/rss/channel/item[1]/media:content/media:hash' )[ 0 ]->attributes[ 0 ]->value
        );

        $this->assertEquals( 2, $xpath->query( '/rss/channel/item[1]/media:content/media:comments/media:comment' )->length );
        $this->assertEquals(
            'This is great',
            $xpath->query( '/rss/channel/item[1]/media:content/media:comments/media:comment' )[ 0 ]->textContent
        );
        $this->assertEquals(
            'I like this',
            $xpath->query( '/rss/channel/item[1]/media:content/media:comments/media:comment' )[ 1 ]->textContent
        );

        $this->assertEquals( 2, $xpath->query( '/rss/channel/item[1]/media:content/media:text' )->length );
        $this->assertEquals(
            'Oh, say, can you see',
            $xpath->query( '/rss/channel/item[1]/media:content/media:text' )[ 0 ]->textContent
        );

        $firstTextAttributes = $this->getAttributesOfElement(
            $xpath->query( '/rss/channel/item[1]/media:content/media:text' )[ 0 ]
        );

        $secondTextAttributes = $this->getAttributesOfElement(
            $xpath->query( '/rss/channel/item[1]/media:content/media:text' )[ 1 ]
        );

        $this->assertArrayHasKey( 'lang', $firstTextAttributes );
        $this->assertEquals( 'en', $firstTextAttributes[ 'lang' ] );
        $this->assertArrayHasKey( 'start', $firstTextAttributes );
        $this->assertEquals( '00:00:03.000', $firstTextAttributes[ 'start' ] );
        $this->assertArrayHasKey( 'end', $firstTextAttributes );
        $this->assertEquals( '00:00:10.000', $firstTextAttributes[ 'end' ] );

        $this->assertArrayHasKey( 'type', $secondTextAttributes );
        $this->assertEquals( 'html', $secondTextAttributes[ 'type' ] );

        $this->assertEquals( 3, $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )->length );
        $this->assertEquals(
            'au',
            $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )[ 0 ]->textContent
        );
        $this->assertEquals(
            '',
            $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )[ 1 ]->textContent
        );
        $this->assertEquals(
            'http://example.com',
            $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )[ 2 ]->textContent
        );

        $firstRestrictionAttributes = $this->getAttributesOfElement(
            $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )[ 0 ]
        );

        $secondRestrictionAttributes = $this->getAttributesOfElement(
            $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )[ 1 ]
        );

        $thirdRestrictionAttributes = $this->getAttributesOfElement(
            $xpath->query( '/rss/channel/item[1]/media:content/media:restriction' )[ 2 ]
        );

        $this->assertArrayHasKey( 'relationship', $firstRestrictionAttributes );
        $this->assertEquals( 'allow', $firstRestrictionAttributes[ 'relationship' ] );
        $this->assertArrayHasKey( 'type', $firstRestrictionAttributes );
        $this->assertEquals( 'country', $firstRestrictionAttributes[ 'type' ] );

        $this->assertArrayHasKey( 'relationship', $secondRestrictionAttributes );
        $this->assertEquals( 'deny', $secondRestrictionAttributes[ 'relationship' ] );
        $this->assertArrayHasKey( 'type', $secondRestrictionAttributes );
        $this->assertEquals( 'sharing', $secondRestrictionAttributes[ 'type' ] );

        $this->assertArrayHasKey( 'relationship', $thirdRestrictionAttributes );
        $this->assertEquals( 'deny', $thirdRestrictionAttributes[ 'relationship' ] );
        $this->assertArrayHasKey( 'type', $thirdRestrictionAttributes );
        $this->assertEquals( 'uri', $thirdRestrictionAttributes[ 'type' ] );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/media:content/media:price' )->length );

        $priceAttributes = $this->getAttributesOfElement(
            $xpath->query( '/rss/channel/item[1]/media:content/media:price' )[ 0 ]
        );

        $this->assertArrayHasKey( 'price', $priceAttributes );
        $this->assertEquals( '19.99', $priceAttributes[ 'price' ] );
        $this->assertArrayHasKey( 'info', $priceAttributes );
        $this->assertEquals( 'http://www.dummy.jp/package_info.html', $priceAttributes[ 'info' ] );
        $this->assertArrayHasKey( 'type', $priceAttributes );
        $this->assertEquals( 'package', $priceAttributes[ 'type' ] );
        $this->assertArrayHasKey( 'currency', $priceAttributes );
        $this->assertEquals( 'EUR', $priceAttributes[ 'currency' ] );

        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes' )->length
        );
        $this->assertEquals(
            2,
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene' )->length
        );
        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneTitle' )->length
        );
        $this->assertEquals(
            'sceneTitle1',
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneTitle' )[ 0 ]->textContent
        );
        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneDescription' )->length
        );
        $this->assertEquals(
            'sceneDesc1',
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneDescription' )[ 0 ]->textContent
        );
        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneStartTime' )->length
        );
        $this->assertEquals(
            '00:15',
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneStartTime' )[ 0 ]->textContent
        );
        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneEndTime' )->length
        );
        $this->assertEquals(
            '00:45',
            $xpath->query( '/rss/channel/item[1]/media:content/media:scenes/media:scene[1]/sceneEndTime' )[ 0 ]->textContent
        );

        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:backLinks' )->length
        );
        $this->assertEquals(
            3,
            $xpath->query( '/rss/channel/item[1]/media:content/media:backLinks/media:backLink' )->length
        );
        $this->assertEquals(
            1,
            $xpath->query( '/rss/channel/item[1]/media:content/media:backLinks/media:backLink[1]' )->length
        );
        $this->assertEquals(
            'http://www.backlink1.com',
            $xpath->query( '/rss/channel/item[1]/media:content/media:backLinks/media:backLink[1]' )[ 0 ]->textContent
        );
        $this->assertEquals(
            'http://www.backlink2.com',
            $xpath->query( '/rss/channel/item[1]/media:content/media:backLinks/media:backLink[2]' )[ 0 ]->textContent
        );
        $this->assertEquals(
            'http://www.backlink3.com',
            $xpath->query( '/rss/channel/item[1]/media:content/media:backLinks/media:backLink[3]' )[ 0 ]->textContent
        );

        $this->assertEquals(
            3,
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating' )->length
        );
        $this->assertEquals(
            'adult',
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating[1]' )[ 0 ]->textContent
        );
        $this->assertEquals(
            'urn:simple',
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating[1]' )[ 0 ]->getAttribute( 'scheme' )
        );
        $this->assertEquals(
            'r (cz 1 lz 1 nz 1 oz 1 vz 1)',
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating[2]' )[ 0 ]->textContent
        );
        $this->assertEquals(
            'urn:icra',
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating[2]' )[ 0 ]->getAttribute( 'scheme' )
        );
        $this->assertEquals(
            'a-rating',
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating[3]' )[ 0 ]->textContent
        );
        $this->assertEquals(
            '',
            $xpath->query( '/rss/channel/item[1]/media:content/media:rating[3]' )[ 0 ]->getAttribute( 'scheme' )
        );

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
            ->title( 'Monkey <strong>rock</strong>', 'html' )
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