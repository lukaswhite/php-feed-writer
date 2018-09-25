<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Atom;
use Lukaswhite\FeedWriter\Entities\Rss\Channel;
use Lukaswhite\FeedWriter\RSS2;

class DublinCoreTest extends TestCase
{
    public function testAddingDublinCoreToRSSChannel( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );

        $channel = $feed->addChannel( );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $date = new \DateTime( '2018-09-04 09:30' );

        $channel
            ->dcTitle( 'Example feed' )
            ->dcCreator( 'creator@example.com' )
            ->dcContributor( 'contributor@example.com' )
            ->dcCoverage( 'United Kingdom' )
            ->dcDate( $date )
            ->dcDescription( 'An example feed' )
            ->dcFormat( 'text/html' )
            ->dcIdentifier ('http://example.com/feed.rss' )
            ->dcLanguage( 'en' )
            ->dcPublisher( 'Example Co' )
            ->dcRelation( 'http://example2.com' )
            ->dcRights( 'Copyright Example' )
            ->dcSource( 'http://example.com' )
            ->dcSubject( 'It is an example' )
            ->dcType( 'Text' );

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:title' )->length );
        $this->assertEquals(
            'Example feed',
            $xpath->query( '/rss/channel/dc:title' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:creator' )->length );
        $this->assertEquals(
            'creator@example.com',
            $xpath->query( '/rss/channel/dc:creator' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:contributor' )->length );
        $this->assertEquals(
            'contributor@example.com',
            $xpath->query( '/rss/channel/dc:contributor' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:coverage' )->length );
        $this->assertEquals(
            'United Kingdom',
            $xpath->query( '/rss/channel/dc:coverage' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:date' )->length );
        $this->assertEquals(
            $date->format( 'Y-m-d' ),
            ( new \DateTime( $xpath->query( '/rss/channel/dc:date' )[ 0 ]->textContent ) )
                ->format( 'Y-m-d' )
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:description' )->length );
        $this->assertEquals(
            'An example feed',
            $xpath->query( '/rss/channel/dc:description' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:format' )->length );
        $this->assertEquals(
            'text/html',
            $xpath->query( '/rss/channel/dc:format' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:identifier' )->length );
        $this->assertEquals(
            'http://example.com/feed.rss',
            $xpath->query( '/rss/channel/dc:identifier' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:language' )->length );
        $this->assertEquals(
            'en',
            $xpath->query( '/rss/channel/dc:language' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:publisher' )->length );
        $this->assertEquals(
            'Example Co',
            $xpath->query( '/rss/channel/dc:publisher' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:relation' )->length );
        $this->assertEquals(
            'http://example2.com',
            $xpath->query( '/rss/channel/dc:relation' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:rights' )->length );
        $this->assertEquals(
            'Copyright Example',
            $xpath->query( '/rss/channel/dc:rights' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:source' )->length );
        $this->assertEquals(
            'http://example.com',
            $xpath->query( '/rss/channel/dc:source' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:subject' )->length );
        $this->assertEquals(
            'It is an example',
            $xpath->query( '/rss/channel/dc:subject' )[ 0 ]->textContent
        );

        $this->assertEquals( 1, $xpath->query( '/rss/channel/dc:type' )->length );
        $this->assertEquals(
            'Text',
            $xpath->query( '/rss/channel/dc:type' )[ 0 ]->textContent
        );



    }

    public function testAddingDublinCoreToRSSItem( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $channel->title('Channel title')
            ->description('A description of the channel')
            ->link('http://example.com');

        $channel->addItem()
            ->title('Item 1 title')
            ->description('A description of the first item')
            ->link('http://example.com/blog/post-1.html')
            ->pubDate(new \DateTime('2018-09-07 09:30'))
            ->dcTitle('Item 1 title');

        $doc = new \DOMDocument();

        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item[1]/dc:title')->length);
        $this->assertEquals(
            'Item 1 title',
            $xpath->query('/rss/channel/item[1]/dc:title')[0]->textContent
        );
    }

    public function testAddingDublinCoreToRSSImage( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $channel->title('Channel title')
            ->description('A description of the channel')
            ->link('http://example.com');

        $channel
            ->addImage( )
            ->dcTitle( 'Image title' );

        $doc = new \DOMDocument();

        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/image/dc:title')->length);
        $this->assertEquals(
            'Image title',
            $xpath->query('/rss/channel/image/dc:title')[0]->textContent
        );
    }

    public function testAddingDublinCoreToRSSTextInput( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $channel->title('Channel title')
            ->description('A description of the channel')
            ->link('http://example.com');

        $channel
            ->addTextInput( )
            ->dcTitle( 'Text input title' );

        $doc = new \DOMDocument();

        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/textInput/dc:title')->length);
        $this->assertEquals(
            'Text input title',
            $xpath->query('/rss/channel/textInput/dc:title')[0]->textContent
        );
    }

}