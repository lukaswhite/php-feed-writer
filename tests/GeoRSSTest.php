<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Atom;
use Lukaswhite\FeedWriter\RSS2;

class GeoRSSTest extends TestCase
{
    public function testAddingPoint( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->geoRSS( )->addPoint( 45.256, -71.92 );

        $this->assertEquals(
            '45.256, -71.92',
            $this->getContentsOfElementNamed( 'georss:point', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }

    public function testAddingLine( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->geoRSS( )->addLine( '45.256 -110.45 46.46 -109.48 43.84 -109.86' );

        $this->assertEquals(
            '45.256 -110.45 46.46 -109.48 43.84 -109.86',
            $this->getContentsOfElementNamed( 'georss:line', $feed->toString( ) )
        );

    }

    public function testAddingPolygon( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->geoRSS( )->addPolygon( '45.256 -110.45 46.46 -109.48 43.84 -109.86 45.256 -110.45' );

        $this->assertEquals(
            '45.256 -110.45 46.46 -109.48 43.84 -109.86 45.256 -110.45',
            $this->getContentsOfElementNamed( 'georss:polygon', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }

    public function testAddingBox( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->geoRSS( )->addBox( '42.943 -71.032 43.039 -69.856' );

        $this->assertEquals(
            '42.943 -71.032 43.039 -69.856',
            $this->getContentsOfElementNamed( 'georss:box', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }

    public function testAddingOtherTags( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->geoRSS( )->addPoint( 45.256, -71.92 );
        $entry->geoRSS( )->featureType( 'city' );
        $entry->geoRSS( )->featureName( 'Manchester' );
        $entry->geoRSS( )->relationshipTag( 'is-centered-on' );
        $entry->geoRSS( )->radius( 500 );
        $entry->geoRSS( )->elevation( 313 );
        $entry->geoRSS( )->floor( 2 );

        $this->assertEquals(
            'city',
            $this->getContentsOfElementNamed( 'georss:featuretypetag', $feed->toString( ) )
        );

        $this->assertEquals(
            'Manchester',
            $this->getContentsOfElementNamed( 'georss:featurename', $feed->toString( ) )
        );

        $this->assertEquals(
            'is-centered-on',
            $this->getContentsOfElementNamed( 'georss:relationshiptag', $feed->toString( ) )
        );

        $this->assertEquals(
            '500',
            $this->getContentsOfElementNamed( 'georss:radius', $feed->toString( ) )
        );

        $this->assertEquals(
            '313',
            $this->getContentsOfElementNamed( 'georss:elev', $feed->toString( ) )
        );

        $this->assertEquals(
            '2',
            $this->getContentsOfElementNamed( 'georss:floor', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }

    public function testGeoRSSIsCenteredOnPoint( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->geoRSS( )->isCenteredOnPoint( 45.256, -71.92 );

        $this->assertEquals(
            '45.256, -71.92',
            $this->getContentsOfElementNamed( 'georss:point', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );
        $this->assertEquals(
            'is-centered-on',
            $this->getContentsOfElementNamed( 'georss:relationshiptag', $feed->toString( ) )
        );

    }

    public function testAddingPointToAtomFeed( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $feed->geoRSS( )->addPoint( 45.256, -71.92 );

        $this->assertEquals(
            '45.256, -71.92',
            $this->getContentsOfElementNamed( 'georss:point', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }

    public function testAddingPointToRSSChannel( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );

        $channel = $feed->addChannel( );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $channel->geoRSS( )->addPoint( 45.256, -71.92 );

        $this->assertEquals(
            '45.256, -71.92',
            $this->getContentsOfElementNamed( 'georss:point', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }

    public function testAddingPointToRSSItem( )
    {
        $feed = new \Lukaswhite\FeedWriter\RSS2( );

        $channel = $feed->addChannel( );

        $channel->title( 'Channel title' )
            ->description( 'A description of the channel' )
            ->link( 'http://example.com' );

        $channel->addItem( )->title( 'Item 1 title' )
            ->description( 'A description of the first item' )
            ->link( 'http://example.com/blog/post-1.html' )
            ->guid( 'http://example.com/blog/post-1.html', true )
            ->geoRSS( )->addPoint( 45.256, -71.92 );

        $this->assertEquals(
            '45.256, -71.92',
            $this->getContentsOfElementNamed( 'georss:point', $feed->toString( ) )
        );

        $this->assertTrue( strpos( $feed->toString( ), 'xmlns:georss="http://www.georss.org/georss' ) > -1 );

    }


}