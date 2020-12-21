<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Entities\Itunes\Channel;
use Lukaswhite\FeedWriter\Entities\Rawvoice\Rawvoice;
use Lukaswhite\FeedWriter\Entities\Rawvoice\Subscribe;
use Lukaswhite\FeedWriter\Itunes;
use Lukaswhite\FeedWriter\RSS2;

class RawvoiceTest extends TestCase
{
    public function testAddingSubscribeLinks( )
    {
        $feed = new \Lukaswhite\FeedWriter\Itunes( );
        $feed->prettyPrint( );

        /** @var Channel $channel */
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
            ->type( Channel::EPISODIC )
            ->generator( 'Feed Writer' )
            ->ttl( 60 )
            ->lastBuildDate( new \DateTime( '2016-03-10 02:00' ) );

        $channel->rawvoice()
            ->subscribe()
            ->feed('http://www.example.com/feed.rss')
            ->tuneIn('https://tunein.com/feed')
            ->googleplay('https://google.com/feed')
            ->iTunes('https://itunes.com/feed')
            ->blubrry('https://blubrry.com/feed')
            ->stitcher('https://stitcher.com/feed')
            ->html('http://www.example.com/feed.html');

        $xml = $feed->build( );

        $this->assertEquals( 'rss', $xml->documentElement->tagName );

        $doc = new \DOMDocument( );



        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $subscribes = $xpath->query( '/rss/channel/rawvoice:subscribe' );
        $this->assertEquals( 1, $subscribes->length );

        $subscribesAttributes = $this->getAttributesOfElementNamed( 'rawvoice:subscribe', $feed->toString( ) );

        $this->assertArrayHasKey( Subscribe::FEED, $subscribesAttributes );
        $this->assertEquals('http://www.example.com/feed.rss', $subscribesAttributes[Subscribe::FEED]);

        $this->assertArrayHasKey( Subscribe::TUNEIN, $subscribesAttributes );
        $this->assertEquals('https://tunein.com/feed', $subscribesAttributes[Subscribe::TUNEIN]);

        $this->assertArrayHasKey( Subscribe::GOOGLEPLAY, $subscribesAttributes );
        $this->assertEquals('https://google.com/feed', $subscribesAttributes[Subscribe::GOOGLEPLAY]);

        $this->assertArrayHasKey( Subscribe::ITUNES, $subscribesAttributes );
        $this->assertEquals('https://itunes.com/feed', $subscribesAttributes[Subscribe::ITUNES]);

        $this->assertArrayHasKey( Subscribe::BLUBRRY, $subscribesAttributes );
        $this->assertEquals('https://blubrry.com/feed', $subscribesAttributes[Subscribe::BLUBRRY]);

        $this->assertArrayHasKey( Subscribe::STITCHER, $subscribesAttributes );
        $this->assertEquals('https://stitcher.com/feed', $subscribesAttributes[Subscribe::STITCHER]);

        $this->assertArrayHasKey( Subscribe::HTML, $subscribesAttributes );
        $this->assertEquals('http://www.example.com/feed.html', $subscribesAttributes[Subscribe::HTML]);

        $this->assertEquals( $feed->toString( ), ( string ) $feed );

        $sxe = new \SimpleXMLElement( $feed->toString( ) );
        $namespaces = $sxe->getNamespaces(true);
        $this->assertArrayHasKey( 'rawvoice', $namespaces );
        $this->assertEquals( Rawvoice::NAMESPACE, $namespaces[ 'rawvoice' ] );
    }

    public function testAddingRating( )
    {
        $feed = new \Lukaswhite\FeedWriter\Itunes( );
        $feed->prettyPrint( );

        /** @var Channel $channel */
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
            ->type( Channel::EPISODIC )
            ->generator( 'Feed Writer' )
            ->ttl( 60 )
            ->lastBuildDate( new \DateTime( '2016-03-10 02:00' ) );

        $channel->rawvoice()
            ->rating('TV-PG')
            ->tv('TV-Y')
            ->movie('TV-Y7');


        $xml = $feed->build( );

        $this->assertEquals( 'rss', $xml->documentElement->tagName );

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $ratings = $xpath->query( '/rss/channel/rawvoice:rating' );
        $this->assertEquals( 1, $ratings->length );

        $this->assertEquals('TV-PG', (string)$ratings[0]->textContent);

        $ratingsAttributes = $this->getAttributesOfElementNamed( 'rawvoice:rating', $feed->toString( ) );

        $this->assertArrayHasKey( 'tv', $ratingsAttributes );
        $this->assertEquals('TV-Y', $ratingsAttributes['tv']);

        $this->assertArrayHasKey( 'movie', $ratingsAttributes );
        $this->assertEquals('TV-Y7', $ratingsAttributes['movie']);

        $sxe = new \SimpleXMLElement( $feed->toString( ) );

        $namespaces = $sxe->getNamespaces(true);

        $this->assertArrayHasKey( 'rawvoice', $namespaces );
        $this->assertEquals( Rawvoice::NAMESPACE, $namespaces[ 'rawvoice' ] );
    }

    public function testAddingOther( )
    {
        $feed = new \Lukaswhite\FeedWriter\Itunes( );
        $feed->prettyPrint( );

        /** @var Channel $channel */
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
            ->type( Channel::EPISODIC )
            ->generator( 'Feed Writer' )
            ->ttl( 60 )
            ->lastBuildDate( new \DateTime( '2016-03-10 02:00' ) );

        $channel->rawvoice()
            ->location('Cleveland, OH')
            ->frequency('Weekly');
            //->poster('http://www.example.com/path/to/poster.png')
            //->isHd();


        $xml = $feed->build( );

        $this->assertEquals( 'rss', $xml->documentElement->tagName );

        $doc = new \DOMDocument( );

        print $feed->toString( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $locations = $xpath->query( '/rss/channel/rawvoice:location' );
        $this->assertEquals( 1, $locations->length );
        $this->assertEquals('Cleveland, OH', (string)$locations[0]->textContent);

        $frequencies = $xpath->query( '/rss/channel/rawvoice:frequency' );
        $this->assertEquals( 1, $frequencies->length );
        $this->assertEquals('Weekly', (string)$frequencies[0]->textContent);

        /**
        $posters = $xpath->query( '/rss/channel/rawvoice:poster' );
        $this->assertEquals( 1, $posters->length );
        $this->assertEquals('http://www.example.com/path/to/poster.png', (string)$posters[0]->textContent);

        $isHds = $xpath->query( '/rss/channel/rawvoice:isHd' );
        $this->assertEquals( 1, $isHds->length );
        $this->assertEquals('yes', (string)$isHds[0]->textContent);**/


        $sxe = new \SimpleXMLElement( $feed->toString( ) );

        $namespaces = $sxe->getNamespaces(true);

        $this->assertArrayHasKey( 'rawvoice', $namespaces );
        $this->assertEquals( Rawvoice::NAMESPACE, $namespaces[ 'rawvoice' ] );
    }


}