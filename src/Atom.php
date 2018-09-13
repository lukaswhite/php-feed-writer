<?php

namespace Lukaswhite\FeedWriter;
use Lukaswhite\FeedWriter\Entities\Atom\Entry;
use Lukaswhite\FeedWriter\Entities\Atom\Generator;
use Lukaswhite\FeedWriter\Entities\Atom\Text;
use Lukaswhite\FeedWriter\Entities\Element;
use Lukaswhite\FeedWriter\Traits\Atom\HasAuthors;
use Lukaswhite\FeedWriter\Traits\Atom\HasCategories;
use Lukaswhite\FeedWriter\Traits\Atom\HasContributors;
use Lukaswhite\FeedWriter\Traits\Atom\HasId;
use Lukaswhite\FeedWriter\Traits\Atom\HasLinks;
use Lukaswhite\FeedWriter\Traits\Atom\HasUpdated;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;
use Lukaswhite\FeedWriter\Traits\Atom\HasTitle;
use Lukaswhite\FeedWriter\Traits\Atom\HasRights;
use Lukaswhite\FeedWriter\Traits\GeoRSS\HasGeoRSS;

/**
 * Class Atom
 *
 * @package Lukaswhite\FeedWriter
 */
class Atom extends Feed
{
    use CreatesDOMElements,
        HasTitle,
        HasUpdated,
        HasId,
        HasAuthors,
        HasContributors,
        HasCategories,
        HasLinks,
        HasRights,
        HasGeoRSS;

    /**
     * The feed type; e.g. RSS1.0, RSS2.0, Atom
     * 
     * @var string
     */
    protected $feedType = 'Atom';

    /**
     * The feed; it's simply a reference to itself, for compatability with entity traits
     *
     * @var self
     */
    protected $feed;

    /**
     * The generator
     *
     * @var Generator
     */
    protected $generator;

    /**
     * The subtitle
     *
     * @var Text
     */
    protected $subtitle;

    /**
     * An icon that represents the feed
     *
     * @var string
     */
    protected $icon;

    /**
     * An larger image that represents the feed
     *
     * @var string
     */
    protected $logo;

    /**
     * The entries that make up this feed
     *
     * @var array
     */
    protected $entries = [ ];

    /**
     * Any custom elements
     *
     * @var array
     */
    protected $elements = [ ];

    /**
     * Feed constructor.
     */
    public function __construct( $encoding = 'UTF-8' )
    {
        parent::__construct( $encoding );
        $this->feed = $this;
    }

    /**
     * Set the generator
     *
     * @param string $name
     * @param string $uri
     * @param string $version
     */
    public function generator( string $name, $uri = null, $version = null )
    {
        $this->generator = ( new Generator( $this->feed ) )->name( $name )
            ->uri( $uri )
            ->version( $version );
    }

    /**
     * Set the subtitle
     *
     * @param string $subtitle
     * @param string $type
     * @param bool $encode
     * @return $this
     */
    public function subtitle( string $subtitle, $type = null, $encode = false ) : self
    {
        $this->subtitle = ( new Text( $this->feed ) )
            ->tagName( 'subtitle')
            ->content( $subtitle )
            ->encode( $encode );

        // Set the type if supplied; otherwise it'll attempt to guess
        if ( $type ) {
            $this->subtitle->type( $type );
        }

        return $this;
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function icon( string $icon ) : self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string $logo
     * @return $this
     */
    public function logo($logo) : self
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * Add a link back to the feed itself
     *
     * @param string $url
     * @return $this
     */
    public function addLinkToSelf( string $url )
    {
        $this
            ->addLink( )
            ->url( $url )
            ->rel( 'self' );

        return $this;
    }

    /**
     * Add an entry to the feed
     *
     * @return Entry
     */
    public function addEntry( ) : Entry
    {
        $entry = new Entry( $this );
        $this->entries[ ] = $entry;
        return $entry;
    }

    /**
     * Add a custom element
     *
     * @param string $tagName
     * @param string $content
     * @param array $attributes
     * @return Element
     */
    public function addElement( string $tagName, $content = null, $attributes = [ ] )
    {
        $element = new Element( $this, $tagName, $content, $attributes );
        $this->elements[ ] = $element;
        return $element;
    }

    /**
     * Get the MIME type used to deliver this feed.
     *
     * @return string
     */
    public function getMimeType( ) : string
    {
        return 'application/atom+xml';
    }

    /**
     * Build the feed
     *
     * @return \DOMDocument
     */
    public function build( ) : \DOMDocument
    {
        // Clear the document, otherwise it'll get rebuilt every time
        // you call toString( ) etc.
        $this->clear( );

        $feed = $this->doc->createElement( 'feed' );
        $feed->setAttribute('xmlns', 'http://www.w3.org/2005/Atom');

        $this->addNamespaces( $feed );

        // If required, add the XSL stylesheet reference
        $this->addXslStylesheet( );

        $this->addTitleElement( $feed );

        if ( $this->subtitle ) {
            $feed->appendChild( $this->subtitle->element( ) );
        }

        $this->addUpdatedElement( $feed );

        $this->addIdElement( $feed );

        $this->addLinkElements( $feed );

        $this->addAuthorElements( $feed );

        $this->addContributorElements( $feed );

        $this->addCategoryElements( $feed );

        $this->addRightsElement( $feed );

        if ( $this->icon ) {
            $feed->appendChild( $this->createElement( 'icon', $this->icon ) );
        }

        if ( $this->logo ) {
            $feed->appendChild( $this->createElement( 'logo', $this->logo ) );
        }

        if ( $this->generator ) {
            $feed->appendChild( $this->generator->element( ) );
        }

        // Optionally add the GeoRSS tags
        if ( $this->geoRSS ) {
            $this->geoRSS->addTags( $feed );
        }

        // Optionally add any custom elements
        if ( count( $this->elements ) ) {
            foreach( $this->elements as $element ) {
                /** @var Element $element */
                $feed->appendChild( $element->element( ) );
            }
        }

        if ( count( $this->entries ) ) {
            foreach( $this->entries as $entry ) {
                /** @var Entry $entry */
                $feed->appendChild( $entry->element( ) );
            }
        }

        $this->doc->appendChild( $feed );

        return $this->doc;
    }

}