<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Atom;

class AtomTest extends TestCase
{
    public function testCreatingFeed( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( 'Example Feed', 'plain' )
            ->subtitle( 'An Example', 'plain' )
            ->addLinkToSelf( 'http://example.org/feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' )
            ->rights( '&amp;copy; 2005 John Doe', 'html' )
            ->icon( 'http://example.org/icon.png' )
            ->logo( 'http://example.org/logo.png' );

        $feed
            ->addLink( )
            ->url( 'http://www.example.org' )
            ->rel( 'alternate' );

        $feed->addAuthor( )
            ->name( 'John Doe' )
            ->email( 'john@doe.com' )
            ->uri( 'http://doe.com/john' );

        $feed->addContributor( )
            ->name( 'Jane Doe' )
            ->email( 'jane@doe.com' )
            ->uri( 'http://doe.com/jane' );

        $feed->addCategory( )
            ->term( 'example' )
            ->scheme( 'http://example.com/categories/')
            ->label( 'An example' );

        $feed->addCategory( )
            ->term( 'example2' )
            ->label( 'Another example' );

        $feed->generator(
            'PHP Feed Writer',
            'https://github.com/lukaswhite/php-feed-writer',
            '1.0' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->published( new \DateTime( '2003-12-11T18:30:02Z' ) )
            ->summary( 'robots and stuff' )
            ->content( '<h1>Atom-Powered Robots Run Amok</h1><p>content here</p>', 'html', true );

        $entry->addAuthor( )
            ->name( 'John Doe' )
            ->email( 'john@doe.com' )
            ->uri( 'http://doe.com/john' );

        $entry->addContributor( )
            ->name( 'Jane Doe' )
            ->email( 'jane@doe.com' )
            ->uri( 'http://doe.com/jane' );

        $entry->addContributor( )
            ->name( 'John Doe' )
            ->email( 'john@doe.com' )
            ->uri( 'http://doe.com/john' );

        $entry->addCategory( )
            ->term( 'example' )
            ->scheme( 'http://example.com/categories/')
            ->label( 'An example' );

        $entry
            ->addLink( )
                ->url( 'http://example.org/2003/12/13/atom03' )
                ->language( 'en-GB' )
                ->length( 10000 );

        $entry->addSource( )
            ->id( 'http://example.org/' )
            ->title( 'Example, Inc.' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );



        //print $feed->toString( );
       // $this->assertTrue( is_string( $feed->toString( ) ) );

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );

        $xpath = new \DOMXPath($doc);

        $this->assertEquals( 1, count( $doc->childNodes ) );
        $this->assertEquals( 'feed', $doc->childNodes[ 0 ]->tagName );

        $this->assertTrue($this->xml_is_equal(
            simplexml_load_file( __DIR__ .'/fixtures/atom.xml' ),
            simplexml_load_string( $feed->toString( ) )
        ));

        /**
        $this->assertEquals( 1, $xpath->query( '/feed/title' )->length );
        $this->assertEquals( 'Example Feed', $xpath->query( '/feed/title' )[ 0 ]->textContent );
        **/

        /**
        $this->assertEquals( 1, $xpath->query( '/feed/title' )->length );
        $this->assertEquals( 'Example Feed', $xpath->query( '/feed/title' )[ 0 ]->textContent );
         **/
    }

    /**
    public function testSettingTypeOfTitle( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint( );

        $feed->title( '<strong>Example</strong> Feed', 'html' )
            ->link( 'http://example.org/' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        print $feed->toString();

        $doc = new \DOMDocument( );

        $doc->loadXML( $feed->toString( ) );
        $xpath = new \DOMXPath($doc);
        //$title = $xpath->query( '//feed/title' )[ 0 ];
        //$this->assertEquals( 'html', $title->getAttribute( 'type' ) );
    }**/

    public function testAddingEnclosure( )
    {
        $feed = new \Lukaswhite\FeedWriter\Atom( );

        $feed->title( 'Example Feed', 'plain' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );

        $entry = $feed->addEntry( )
            ->title( 'Atom-Powered Robots Run Amok' )
            ->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );

        $entry->addEnclosure( )
            ->url( 'http://example.com/audio.mp3' )
            ->length( 1000 )
            ->type( 'audio/mpeg' );

        $this->assertTrue(
            strpos(
                $feed->toString( ),
                '<link href="http://example.com/audio.mp3" rel="enclosure" type="audio/mpeg" length="1000"'
            ) > -1
        );
    }

    public function testAddingCustomElements( )
    {

        $feed = new \Lukaswhite\FeedWriter\Atom( );
        $feed->prettyPrint();

        $feed->title( 'Example Feed', 'plain' )
            ->subtitle( 'An Example' )
            ->addLinkToSelf( 'http://example.org/feed' )
            ->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
            ->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' )
            ->rights( '&amp;copy; 2005 John Doe', 'html' )
            ->icon( 'http://example.org/icon.png' )
            ->logo( 'http://example.org/logo.png' );

        $feed->registerNamespace( 'foo', 'http://foo.com' );

        $bar = $feed->addElement( 'foo:bar', 'just a test', [ 'x' => 1, 'y' => 2 ] );

        //print $feed->toString( );

        $this->assertTrue($this->xml_is_equal(
            simplexml_load_file( __DIR__ .'/fixtures/atom-with-custom-element.xml' ),
            simplexml_load_string( $feed->toString( ) )
        ));
    }

}