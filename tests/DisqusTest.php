<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Atom;
use Lukaswhite\FeedWriter\RSS2;

class DisqusTest extends TestCase
{
    public function testAddingDisqusThreadIdentifier( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );
        $feed->prettyPrint( );
        $this->assertTrue( $feed->getDocument( )->formatOutput );

        $channel = $feed->addChannel( );

        $channelPubDate = new \DateTime( '2018-09-04 09:30' );
        $channelLastBuildDate = new \DateTime( '2018-09-06 17:30' );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $item = $channel->addItem( );

        $item->disqusThreadIdentifier( 'disq1234' );

        $this->assertEquals(
            'disq1234',
            $this->getContentsOfElementNamed( 'dsq:thread_identifier', $feed->toString( ) )
        );

        $sxe = new \SimpleXMLElement( $feed->toString( ) );

        $namespaces = $sxe->getNamespaces(true);

        $this->assertArrayHasKey( 'dsq', $namespaces );
        $this->assertEquals( 'http://www.disqus.com/', $namespaces[ 'dsq' ] );
    }

}