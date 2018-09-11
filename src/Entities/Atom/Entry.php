<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\Atom\Enclosure;
use Lukaswhite\FeedWriter\Traits\Atom\HasAuthors;
use Lukaswhite\FeedWriter\Traits\Atom\HasCategories;
use Lukaswhite\FeedWriter\Traits\Atom\HasContributors;
use Lukaswhite\FeedWriter\Traits\Atom\HasId;
use Lukaswhite\FeedWriter\Traits\Atom\HasLinks;
use Lukaswhite\FeedWriter\Traits\Atom\HasRights;
use Lukaswhite\FeedWriter\Traits\Atom\HasUpdated;
use Lukaswhite\FeedWriter\Traits\Atom\HasTitle;
use Lukaswhite\FeedWriter\Traits\GeoRSS\HasGeoRSS;

/**
 * Class Entry
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Entry extends Entity
{
    use HasTitle,
        HasLinks,
        HasId,
        HasAuthors,
        HasContributors,
        HasCategories,
        HasUpdated,
        HasRights,
        HasGeoRSS;

    /**
     * The date and time that this entry was published
     *
     * @var \DateTime
     */
    protected $published;

    /**
     * The content
     *
     * @var Text
     */
    protected $content;

    /**
     * The summary
     *
     * @var Text
     */
    protected $summary;

    /**
     * The source; metadata from the source feed if this entry is a copy.
     *
     * @var Source
     */
    protected $source;

    /**
     * Any enclosures attached to the entry
     *
     * @var array
     */
    protected $enclosures = [ ];

    /**
     * Set the content
     *
     * @param string $content
     * @param string $type
     * @param bool $encode
     * @return $this
     */
    public function content( string $content, $type = null, $encode = false ) : self
    {
        $this->content = ( new Text( $this->feed ) )
            ->tagName( 'content')
            ->content( $content )
            ->encode( $encode );

        // Set the type if supplied; otherwise it'll attempt to guess
        if ( $type ) {
            $this->content->type( $type );
        }

        return $this;
    }

    /**
     * Set the summary
     *
     * @param string $summary
     * @param string $type
     * @param bool $encode
     * @return $this
     */
    public function summary( string $summary, $type = null, $encode = false ) : self
    {
        $this->summary = ( new Text( $this->feed ) )
            ->tagName( 'summary')
            ->content( $summary )
            ->encode( $encode );

        // Set the type if supplied; otherwise it'll attempt to guess
        if ( $type ) {
            $this->summary->type( $type );
        }

        return $this;
    }

    /**
     * Add a source
     *
     * @return Source
     */
    public function addSource( ) : Source
    {
        $this->source = new Source( $this->feed );
        return $this->source;
    }

    /**
     * Specify the date and time that this entry was published
     *
     * @param \DateTime $published
     * @return $this
     */
    public function published( \DateTime $published ) : self
    {
        $this->published = $published;
        return $this;
    }

    /**
     * Add an enclosure
     *
     * @return Enclosure
     */
    public function addEnclosure( ) : Enclosure
    {
        $enclosure = new Enclosure( $this->feed );
        $this->enclosures[ ] = $enclosure;
        return $enclosure;
    }

    /**
     * Convert the enclosures to links; i.e. links where the rel is set to "enclosure",
     * that point to the URL of the enclosure file.
     *
     * @return void
     */
    protected function convertEnclosuresToLinks( ) : void
    {
        if ( count( $this->enclosures ) ) {
            foreach( $this->enclosures as $enclosure ) {
                $this->links[ ] = $enclosure->toLink( );
            }
        }
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $entry = $this->createElement( 'entry' );

        $this->addTitleElement( $entry );

        $this->convertEnclosuresToLinks( );

        $this->addLinkElements( $entry );

        $this->addUpdatedElement( $entry );

        $this->addIdElement( $entry );

        $this->addAuthorElements( $entry );

        $this->addContributorElements( $entry );

        if ( $this->published ) {
            $entry->appendChild(
                $this->createElement(
                    'published',
                    $this->published->format( DATE_ATOM )
                )
            );
        }

        $this->addRightsElement( $entry );

        if ( $this->summary ) {
            $entry->appendChild( $this->summary->element( ) );
        }

        if ( $this->content ) {
            $entry->appendChild( $this->content->element( ) );
        }

        if ( $this->source ) {
            $entry->appendChild( $this->source->element( ) );
        }

        $this->addCategoryElements( $entry );

        // Optionally add the GeoRSS tags
        if ( $this->geoRSS ) {
            $this->geoRSS->addTags( $entry );
        }

        // Add any custom elements
        $this->addElementsToDOMElement( $entry );

        return $entry;
    }
}