<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Itunes;
use Lukaswhite\FeedWriter\RSS2;

class ItunesTest extends TestCase
{
    public function testCreatingFeed( )
    {
        $feed = new \Lukaswhite\FeedWriter\Itunes( );
        $feed->prettyPrint( );

        $channel = $feed->addChannel( );

        $channel->title( 'All About Everything' )
            ->subtitle( 'A show about everything' )
            ->description( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store' )
            ->summary( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store' )
            ->link( 'http://www.example.com/podcasts/everything/index.html' )
            ->image( 'http://example.com/podcasts/everything/AllAboutEverything.jpg' )
            ->author( 'John Doe' )
            ->owner( 'John Doe', 'john.doe@example.com' )
            ->explicit( 'no' )
            ->copyright( '&#x2117; &amp; &#xA9; 2014 John Doe &amp; Family' )
            ->generator( 'Feed Writer' )
            ->ttl( 60 )
            ->lastBuildDate( new \DateTime( '2016-03-10 02:00' ) );

        $channel->addItem( )
            ->title( 'Shake Shake Shake Your Spices' )
            ->author( 'John Doe' )
            ->subtitle( 'A short primer on table spices' )
            ->duration( '07:04' )
            ->summary( 'This week we talk about <a href="https://itunes/apple.com/us/book/antique-trader-salt-pepper/id429691295?mt=11">salt and pepper shakers</a>, comparing and contrasting pour rates, construction materials, and overall aesthetics. Come and join the party!' )
            ->pubDate( new \DateTime( '2016-03-08 12:00' ) )
            ->guid( 'http://example.com/podcasts/archive/aae20140615.m4a' )
            ->explicit( 'no' )
            ->addEnclosure( )
                ->url( 'http://example.com/podcasts/everything/AllAboutEverythingEpisode3.m4a' )
                ->length( 8727310 )
                ->type( 'audio/x-m4a' );


        $item2 = $channel->addItem( );

        $item2->title( 'The Best Chili' )
            ->author( 'Jane Doe' )
            ->subtitle( 'Jane and Eric' )
            ->duration( 274 )
            ->summary( 'This week we talk about the best Chili in the world. Which chili is better?' )
            ->image( 'http://example.com/podcasts/everything/AllAboutEverything/Episode3.jpg' )
            ->link( 'http://example.com/blog/post-1.html' )
            ->pubDate( new \DateTime( '2016-03-10 02:00' ) )
            ->guid( 'http://example.com/podcasts/archive/aae20140697.m4v' )
            ->explicit( 'yes' )
            ->isClosedCaptioned( );

        $item2->addEnclosure( )
            ->url( 'http://example.com/podcasts/everything/AllAboutEverythingEpisode2.m4v' )
            ->length( 5650889 )
            ->type( 'video/x-m4v' );

        $this->assertTrue( is_array( $channel->getItems( ) ) );
        $this->assertEquals( 2, count( $channel->getItems( ) ) );

        $xml = $feed->build( );
        $this->assertEquals( 'rss', $xml->documentElement->tagName );

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);
        $channels = $xpath->query( '/rss/channel' );
        $this->assertEquals( 1, $channels->length );

        $titles = $xpath->query( '/rss/channel/title' );
        $this->assertEquals( 1, $titles->length );
        $this->assertEquals( 'All About Everything', $titles[ 0 ]->textContent );

        $subtitles = $xpath->query( '/rss/channel/itunes:subtitle' );
        $this->assertEquals( 1, $subtitles->length );
        $this->assertEquals( 'A show about everything', $subtitles[ 0 ]->textContent );

        $images = $xpath->query( '/rss/channel/itunes:image' );
        $this->assertEquals( 1, $images->length );
        $this->assertEquals( 'http://example.com/podcasts/everything/AllAboutEverything.jpg', $images[ 0 ]->textContent );

        $explicits = $xpath->query( '/rss/channel/itunes:explicit' );
        $this->assertEquals( 1, $explicits->length );
        $this->assertEquals( 'no', $explicits[ 0 ]->textContent );

        $summaries = $xpath->query( '/rss/channel/itunes:summary' );
        $this->assertEquals( 1, $summaries->length );
        $this->assertEquals( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store', $summaries[ 0 ]->textContent );

        $authors = $xpath->query( '/rss/channel/itunes:author' );
        $this->assertEquals( 1, $authors->length );
        $this->assertEquals( 'John Doe', $authors[ 0 ]->textContent );

        $owners = $xpath->query( '/rss/channel/itunes:owner' );
        $this->assertEquals( 1, $owners->length );

        $ownerNames = $xpath->query( '/rss/channel/itunes:owner/itunes:name' );
        $this->assertEquals( 1, $ownerNames->length );
        $this->assertEquals( 'John Doe', $ownerNames[ 0 ]->textContent );

        $ownerEmails = $xpath->query( '/rss/channel/itunes:owner/itunes:email' );
        $this->assertEquals( 1, $ownerEmails->length );
        $this->assertEquals( 'john.doe@example.com', $ownerEmails[ 0 ]->textContent );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd' ) > -1 );

        $items = $xpath->query( '/rss/channel/item' );
        $this->assertEquals( 2, $items->length );

        $firstItemTitles = $xpath->query( '/rss/channel/item[1]/title' );
        $this->assertEquals( 1, $firstItemTitles->length );
        $this->assertEquals( 'Shake Shake Shake Your Spices', $firstItemTitles[ 0 ]->textContent );

        $firstItemSubtitles = $xpath->query( '/rss/channel/item[1]/itunes:subtitle' );
        $this->assertEquals( 1, $firstItemSubtitles->length );
        $this->assertEquals( 'A short primer on table spices', $firstItemSubtitles[ 0 ]->textContent );

        $firstItemSummaries = $xpath->query( '/rss/channel/item[1]/itunes:summary' );
        $this->assertEquals( 1, $firstItemSummaries->length );
        $this->assertEquals( 'This week we talk about <a href="https://itunes/apple.com/us/book/antique-trader-salt-pepper/id429691295?mt=11">salt and pepper shakers</a>, comparing and contrasting pour rates, construction materials, and overall aesthetics. Come and join the party!', $firstItemSummaries[ 0 ]->textContent );

        $firstItemExplicits = $xpath->query( '/rss/channel/item[1]/itunes:explicit' );
        $this->assertEquals( 1, $firstItemExplicits->length );
        $this->assertEquals( 'no', $firstItemExplicits[ 0 ]->textContent );

        $firstItemDurations = $xpath->query( '/rss/channel/item[1]/itunes:duration' );
        $this->assertEquals( 1, $firstItemDurations->length );
        $this->assertEquals( '07:04', $firstItemDurations[ 0 ]->textContent );

        $secondItemDurations = $xpath->query( '/rss/channel/item[2]/itunes:duration' );
        $this->assertEquals( 1, $secondItemDurations->length );
        $this->assertEquals( '04:34', $secondItemDurations[ 0 ]->textContent );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[2]/itunes:isClosedCaptioned' )->length );
        $this->assertEquals( 'Yes', $xpath->query( '/rss/channel/item[2]/itunes:isClosedCaptioned' )[ 0 ]->textContent );

        $enclosures = $xpath->query( '/rss/channel/item[1]/enclosure' );
        $this->assertEquals( 1, $enclosures->length );
        $enclosureAttributes = $this->getAttributesOfElementNamed( 'enclosure', $feed->toString( ) );
        $this->assertArrayHasKey( 'url', $enclosureAttributes );
        $this->assertEquals( 'http://example.com/podcasts/everything/AllAboutEverythingEpisode3.m4a', $enclosureAttributes[ 'url' ] );
        $this->assertArrayHasKey( 'length', $enclosureAttributes );
        $this->assertEquals( '8727310', $enclosureAttributes[ 'length' ] );
        $this->assertArrayHasKey( 'type', $enclosureAttributes );
        $this->assertEquals( 'audio/x-m4a', $enclosureAttributes[ 'type' ] );

        $this->assertEquals( $feed->toString( ), ( string ) $feed );
    }

    public function testAdditionalElements( )
    {
        $feed = new \Lukaswhite\FeedWriter\Itunes( );
        $feed->prettyPrint( );

        $channel = $feed->addChannel( );

        $channel->title( 'All About Everything' )
            ->subtitle( 'A show about everything' )
            ->description( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store' )
            ->summary( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store' )
            ->link( 'http://www.example.com/podcasts/everything/index.html' )
            ->image( 'http://example.com/podcasts/everything/AllAboutEverything.jpg' )
            ->author( 'John Doe' )
            ->owner( 'John Doe', 'john.doe@example.com' )
            ->explicit( 'no' )
            ->copyright( '&#x2117; &amp; &#xA9; 2014 John Doe &amp; Family' )
            ->generator( 'Feed Writer' )
            ->ttl( 60 )
            ->lastBuildDate( new \DateTime( '2016-03-10 02:00' ) )
            ->newFeedUrl( 'http://example2.com/feed.xml' )
            ->isComplete( )
            ->block( );

        $item1 = $channel->addItem( );

        $item1->title( 'Shake Shake Shake Your Spices' )
            ->author( 'John Doe' )
            ->subtitle( 'A short primer on table spices' )
            ->duration( '1:07:04' )
            ->summary( 'This week we talk about <a href="https://itunes/apple.com/us/book/antique-trader-salt-pepper/id429691295?mt=11">salt and pepper shakers</a>, comparing and contrasting pour rates, construction materials, and overall aesthetics. Come and join the party!' )
            ->pubDate( new \DateTime( '2016-03-08 12:00' ) )
            ->guid( 'http://example.com/podcasts/archive/aae20140615.m4a' )
            ->explicit( 'no' )
            ->order( 3 );

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/itunes:block' )->length );
        $this->assertEquals( 'Yes', $xpath->query( '/rss/channel/itunes:block' )[ 0 ]->textContent );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/itunes:complete' )->length );
        $this->assertEquals( 'Yes', $xpath->query( '/rss/channel/itunes:complete' )[ 0 ]->textContent );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/itunes:new-feed-url' )->length );
        $this->assertEquals( 'http://example2.com/feed.xml', $xpath->query( '/rss/channel/itunes:new-feed-url' )[ 0 ]->textContent );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/item[1]/itunes:order' )->length );
        $this->assertEquals( '3', $xpath->query( '/rss/channel/item[1]/itunes:order' )[ 0 ]->textContent );

    }

    public function testGettingMimeType( )
    {
        $feed = new Itunes( );
        $this->assertEquals( 'application/rss+xml', $feed->getMimeType( ) );
    }

}