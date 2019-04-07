<?php

namespace Lukaswhite\FeedWriter\Entities\Rss;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\General\Enclosure;
use Lukaswhite\FeedWriter\Traits\Disqus\HasDisqus;
use Lukaswhite\FeedWriter\Traits\DublinCore\SupportsDublinCore;
use Lukaswhite\FeedWriter\Traits\GeoRSS\HasGeoRSS;
use Lukaswhite\FeedWriter\Traits\HasCategories;
use Lukaswhite\FeedWriter\Traits\HasLink;
use Lukaswhite\FeedWriter\Traits\HasMedia;
use Lukaswhite\FeedWriter\Traits\HasMediaGroups;
use Lukaswhite\FeedWriter\Traits\HasPublishedDate;
use Lukaswhite\FeedWriter\Traits\HasTitle;
use Lukaswhite\FeedWriter\Traits\HasDescription;

/**
 * Class Item
 *
 * @package Lukaswhite\FeedWriter\Entities\Rss
 */
class Item extends Entity
{
    use HasTitle,
        HasDescription,
        HasLink,
        HasPublishedDate,
        HasCategories,
        HasMedia,
        HasMediaGroups,
        HasGeoRSS,
        SupportsDublinCore,
        HasDisqus;

    /**
     * The GUID (globally unique identifier)
     *
     * @var string
     */
    protected $guid;

    /**
     * Whether the GUID is a permalink
     *
     * @var bool
     */
    protected $guidIsPermalink = false;

    /**
     * The encoded content of this item
     *
     * @var string
     */
    protected $encodedContent;

    /**
     * The author of the item
     *
     * @var string
     */
    protected $author;

    /**
     * The enclosures
     *
     * @var array
     */
    protected $enclosures = [ ];

    /**
     * Set the GUID
     *
     * @param string $guid
     * @param bool $isPermalink
     * @return $this
     */
    public function guid( string $guid, bool $isPermalink = false ) : self
    {
        $this->guid = $guid;
        $this->guidIsPermalink = $isPermalink;
        return $this;
    }

    /**
     * Set the encoded content of the item
     *
     * @param string $encodedContent
     * @return $this
     */
    public function encodedContent( string $encodedContent ) : self
    {
        $this->encodedContent = $encodedContent;
        return $this;
    }

    /**
     * Set the author of the item
     *
     * @param string $author
     * @return $this
     */
    public function author( string $author )
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Add an enclosure
     *
     * @return Enclosure
     */
    public function addEnclosure( ) : Enclosure
    {
        $enclosure = $this->createEntity( Enclosure::class );
        $this->enclosures[ ] = $enclosure;
        return $enclosure;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $item = $this->feed->getDocument( )->createElement( 'item' );

        $this->addTitleElement( $item );
        $this->addDescriptionElement( $item );

        $this->addLinkElement( $item );

        if ( $this->guid ) {

            if ( $this->guidIsPermalink ) {
                $guid = $this->createElement( 'guid', $this->guid, [ 'isPermaLink' => 'true'  ] );
            } else {
                $guid = $this->createElement( 'guid', $this->guid );
            }
            $item->appendChild( $guid );
        }

        $this->addPublishedDateElement( $item );

        if ( $this->encodedContent ) {
            $item->appendChild(
                $this->createElement(
                    'content:encoded',
                    $this->encodedContent,
                    [ ],
                    true
                )
            );
        }

        if ( $this->author ) {
            $item->appendChild( $this->createElement( 'author', $this->author ) );
        }

        $this->addCategoryElements( $item );

        if ( count( $this->enclosures ) ) {
            foreach( $this->enclosures as $enclosure ) {
                $item->appendChild( $enclosure->element( $this->feed->getDocument( ) ) );
            }
        }

        $this->addDublinCoreTags( $item );

        $this->addDisqusTags( $item );

        $this->addMediaElements( $item );
        $this->addMediaGroupElements( $item );

        $this->addElementsToDOMElement( $item );

        // Optionally add the GeoRSS tags
        if ( $this->geoRSS ) {
            $this->geoRSS->addTags( $item );
        }

        return $item;
    }
}