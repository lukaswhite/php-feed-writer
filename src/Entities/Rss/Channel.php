<?php

namespace Lukaswhite\FeedWriter\Entities\Rss;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\General\Link;
use Lukaswhite\FeedWriter\Entities\General\Image;
use Lukaswhite\FeedWriter\Traits\DublinCore\SupportsDublinCore;
use Lukaswhite\FeedWriter\Traits\GeoRSS\HasGeoRSS;
use Lukaswhite\FeedWriter\Traits\HasCategories;
use Lukaswhite\FeedWriter\Traits\HasLink;
use Lukaswhite\FeedWriter\Traits\HasPublishedDate;
use Lukaswhite\FeedWriter\Traits\HasTextInput;
use Lukaswhite\FeedWriter\Traits\HasTitle;
use Lukaswhite\FeedWriter\Traits\HasDescription;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Rss
 */
class Channel extends Entity
{
    use HasTitle,
        HasDescription,
        HasLink,
        HasPublishedDate,
        HasCategories,
        HasTextInput,
        HasGeoRSS,
        SupportsDublinCore;

    /**
     * The date and time that the feed was last built
     *
     * @var \DateTime
     */
    protected $lastBuildDate;

    /**
     * The language
     *
     * @var string
     */
    protected $language = 'en-GB';

    /**
     * The copyright notice
     *
     * @var string
     */
    protected $copyright;

    /**
     * The program used to create the channel
     *
     * @var string
     */
    protected $generator;

    /**
     * The ttl (Time to Live)
     *
     * @var int
     */
    protected $ttl;

    /**
     * The channel's image, if provided.
     *
     * @var Image
     */
    protected $image;

    /**
     * The links
     *
     * @var array
     */
    protected $links = [ ];

    /**
     * The cloud element indicates that updates to the feed can be monitored using a web service
     * that implements the RssCloud application programming interface
     *
     * @var Cloud
     */
    protected $cloud;

    /**
     * The webmaster
     *
     * @var string
     */
    protected $webmaster;

    /**
     * The managing editor
     *
     * @var string
     */
    protected $managingEditor;

    /**
     * The (PICS) rating
     *
     * @var string
     */
    protected $rating;

    /**
     * The days on which the feed is not updated
     *
     * @var array
     */
    protected $skipDays;

    /**
     * The hours of the day during which the feed is not updated
     *
     * @var array
     */
    protected $skipHours;

    /**
     * The items that make up this channel
     *
     * @var array
     */
    protected $items = [ ];

    /**
     * Set the last build date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function lastBuildDate( \DateTime $date ) : self
    {
        $this->lastBuildDate = $date;
        return $this;
    }

    /**
     * Set the language
     *
     * @param $language
     * @return $this
     */
    public function language( $language ) : self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Set the copyright notice
     *
     * @param $copyright
     * @return $this
     */
    public function copyright( $copyright ) : self
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * Set the name of the program used to generate the channel
     *
     * @param $generator
     * @return $this
     */
    public function generator( string $generator ) : self
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * Set the ttl
     *
     * @param $ttl
     * @return $this
     */
    public function ttl( int $ttl ) : self
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Set the webmaster
     *
     * @param string $webmaster
     * @return Channel
     */
    public function webmaster( string $webmaster ) : self
    {
        $this->webmaster = $webmaster;
        return $this;
    }

    /**
     * Set the managing editor
     *
     * @param string $managingEditor
     * @return Channel
     */
    public function managingEditor( string $managingEditor ) : self
    {
        $this->managingEditor = $managingEditor;
        return $this;
    }

    /**
     * Set the (PICS) rating
     *
     * @var string
     * @return Channel
     */
    public function rating( string $rating ) : self
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Set the days on which the feed is not updated
     *
     * e.g.
     *
     * ->skipDays( 'Saturday', 'Sunday' )
     *
     * @param string ...$days
     * @return Channel
     */
    public function skipDays( string ...$days )
    {
        $this->skipDays = array_unique( $days );
        return $this;
    }

    /**
     * Set the hours at which the feed is not updated
     *
     * e.g.
     *
     * ->skipHours( 0, 1, 2, 3, 4 )
     *
     * @param int ...$hours
     * @return Channel
     */
    public function skipHours( string ...$hours )
    {
        $this->skipHours = array_unique( $hours );
        return $this;
    }

    /**
     * Add an image
     *
     * @return Image
     */
    public function addImage( )
    {
        $this->image = new Image( $this->feed );
        return $this->image;
    }

    /**
     * Add a link
     *
     * @param string $name
     * @param string $url
     * @param string $rel
     * @param string $type
     * @return $this
     */
    public function addLink( $name, $url, $rel = null, $type = null ) : self
    {
        $link = new Link( $this->feed );
        $link->tagName( $name )
            ->url( $url );

        if ( $rel ) {
            $link->rel( $rel );
        }

        if ( $type ) {
            $link->type( $type );
        }

        $this->links[ ] = $link;

        return $this;
    }

    /**
     * Add an Atom link
     *
     * @param string $url
     * @param bool $self
     * @return $this
     */
    public function addAtomLink( $url, $self = false ) : self
    {
        // Add the link
        $this->addLink(
            'atom:link',
            $url,
            ( $self ) ? 'self' : null,
            'application/atom+xml'
        );

        // If the Atom namespace has not been registered, do so now
        if ( ! $this->feed->isNamespaceRegistered( 'atom' ) ) {
            $this->feed->registerAtomNamespace( );
        }

        return $this;
    }

    /**
     * Add a PubSubHubbub link
     *
     * @param string $url
     * @return Channel
     */
    public function addPubSubHubbubLink( $url )
    {
        return $this->addLink(
            'atom:link',
            $url,
            'hub'
        );
    }

    /**
     * Add a cloud element
     *
     * @return Cloud
     */
    public function addCloud( )
    {
        $this->cloud = new Cloud( $this->feed );
        return $this->cloud;
    }

    /**
     * Add an item
     *
     * @return Item
     */
    public function addItem( )
    {
        $item = $this->createEntity( Item::class );
        /** @var Item $item */
        $this->items[ ] = $item;
        return $item;
    }

    /**
     * Get the items
     *
     * @return array
     */
    public function getItems( ) : array
    {
        return $this->items;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( )  : \DOMElement
    {
        $channel = $this->createElement( 'channel' );

        $this->addTitleElement( $channel );

        $this->addDescriptionElement( $channel );

        $this->addLinkElement( $channel );

        if ( $this->language ) {
            $channel->appendChild( $this->createElement( 'language', $this->language ) );
        }

        if ( $this->copyright ) {
            $channel->appendChild( $this->createElement( 'copyright', $this->copyright ) );
        }

        if ( $this->lastBuildDate ) {
            $channel->appendChild( $this->createElement(
                'lastBuildDate',
                $this->lastBuildDate->format( DATE_RSS ) )
            );
        }

        $this->addPublishedDateElement( $channel );

        if ( $this->generator ) {
            $channel->appendChild( $this->createElement( 'generator', $this->generator ) );
        }

        if ( $this->webmaster ) {
            $channel->appendChild( $this->createElement( 'webMaster', $this->webmaster ) );
        }

        if ( $this->managingEditor ) {
            $channel->appendChild( $this->createElement( 'managingEditor', $this->managingEditor ) );
        }

        if ( $this->rating ) {
            $channel->appendChild( $this->createElement( 'rating', $this->rating ) );
        }

        if ( $this->ttl ) {
            $channel->appendChild( $this->createElement( 'ttl', $this->ttl ) );
        }

        if ( $this->skipDays && count( $this->skipDays ) ) {
            $skipDays = $channel->appendChild( $this->createElement( 'skipDays' ) );
            foreach( $this->skipDays as $day ) {
                $skipDays->appendChild( $this->createElement( 'day', $day ) );
            }
        }

        if ( $this->skipHours && count( $this->skipHours ) ) {
            $skipHours = $channel->appendChild( $this->createElement( 'skipHours' ) );
            foreach( $this->skipHours as $hour ) {
                $skipHours->appendChild( $this->createElement( 'hour', $hour ) );
            }
        }

        if ( $this->image ) {
            $channel->appendChild( $this->image->element( ) );
        }

        if ( count( $this->links ) ) {
            foreach( $this->links as $link ) {
                $channel->appendChild( $link->element(  ) );
            }
        }

        // Optionally add the categories
        $this->addCategoryElements( $channel );

        // Optionally add the textInput
        $this->addTextInputElement( $channel );

        // Optionally add the cloud element
        if ( $this->cloud ) {
            $channel->appendChild( $this->cloud->element( ) );
        }

        // Optionally add any Dublin Core tags
        $this->addDublinCoreTags( $channel );

        // Optionally add the GeoRSS tags
        if ( $this->geoRSS ) {
            $this->geoRSS->addTags( $channel );
        }

        // Add any custom elements
        $this->addElementsToDOMElement( $channel );

        // Now add the items
        if ( count( $this->items ) ) {
            foreach( $this->items as $item ) {
                $channel->appendChild( $item->element( ) );
            }
        }

        return $channel;

    }
}