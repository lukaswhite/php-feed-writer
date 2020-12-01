<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

use Lukaswhite\FeedWriter\Traits\Itunes\HasAuthor;
use Lukaswhite\FeedWriter\Traits\Itunes\HasBlock;
use Lukaswhite\FeedWriter\Traits\Itunes\HasEpisodeType;
use Lukaswhite\FeedWriter\Traits\Itunes\HasExplicit;
use Lukaswhite\FeedWriter\Traits\Itunes\HasImage;
use Lukaswhite\FeedWriter\Traits\Itunes\HasSubtitle;
use Lukaswhite\FeedWriter\Traits\Itunes\HasSummary;

/**
 * Class Item
 *
 * @package Lukaswhite\FeedWriter\Entities\Itunes
 */
class Item extends \Lukaswhite\FeedWriter\Entities\Rss\Item
{
    use HasSubtitle,
        HasSummary,
        HasAuthor,
        HasImage,
        HasExplicit,
        HasBlock,
        HasEpisodeType;

    /**
     * The duration of the item. Note that this is stored as an integer; i.e. the number of seconds,
     * but converted to the correct format at the appropriate time.
     *
     * @var integer
     */
    protected $duration;

    /**
     * Whether this item is closed-captioned.
     *
     * @var bool
     */
    protected $isClosedCaptioned;

    /**
     * The number in which this item should appear, overriding the published date.
     *
     * @var int
     */
    protected $order;

    /**
     * The episode number
     *
     * @var int
     */
    protected $episode;

    /**
     * The season
     *
     * @var int
     */
    protected $season;

    /**
     * Set the duration
     *
     * @param int|string $value
     * @return $this
     */
    public function duration( $value ) : self
    {
        if ( is_int( $value ) ) {
            $this->duration = $value;
        } elseif( is_string( $value ) ) {
            $this->duration = $this->parseDurationString( $value );
        }
        return $this;
    }

    /**
     * Specify that this item is closed-captioned.
     *
     * @param bool $value
     * @return $this
     */
    public function isClosedCaptioned( $value = true )
    {
        $this->isClosedCaptioned = $value;
        return $this;
    }

    /**
     * Specify the number in which this item should appear, overriding the published date.
     *
     * @param int $order
     * @return $this
     */
    public function order( int $order )
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Specify the episode number
     *
     * @param int $episode
     * @return $this
     */
    public function episode( int $episode )
    {
        $this->episode = $episode;
        return $this;
    }

    /**
     * Specify the season
     *
     * @param int $season
     * @return $this
     */
    public function season( int $season )
    {
        $this->season = $season;
        return $this;
    }

    /**
     * Parse a duration string
     *
     * e.g. parseDurationString( '03:23' ) == 203
     *
     * @param $duration
     * @return int
     */
    protected function parseDurationString( $duration ) : int
    {
        $parts = explode( ':', $duration );
        if ( count( $parts ) == 3 ) {
            return ( intval( $parts[ 0 ] ) * 3600 ) + ( intval( $parts[ 1 ] ) * 60 ) + intval( $parts[ 2 ] );
        }
        return ( intval( $parts[ 0 ] ) * 60 ) + intval( $parts[ 1 ] );
    }

    /**
     * Format the duration
     *
     * @return string
     */
    protected function formatDuration( )
    {
        return ( $this->duration <= 3599 ) ? gmdate('i:s', $this->duration ) :
            gmdate('H:i:s', $this->duration );
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $item = parent::element( );
        $this->addSubtitleElement( $item );
        $this->addSummaryElement( $item );
        $this->addAuthorElement( $item );
        $this->addImageElement( $item );
        $this->addExplicitElement( $item );
        if ( $this->duration ) {
            $item->appendChild( $this->createElement(
                'itunes:duration',
                $this->formatDuration( )
            ) );
        }
        if ( $this->isClosedCaptioned ) {
            $item->appendChild( $this->createElement('itunes:isClosedCaptioned', 'Yes' ) );
        }

        $this->addBlockElement( $item );

        $this->addEpisodeTypeElement( $item );

        if ( $this->order ) {
            $item->appendChild( $this->createElement('itunes:order', $this->order ) );
        }

        if ( $this->episode ) {
            $item->appendChild( $this->createElement('itunes:episode', $this->episode ) );
        }

        if ( $this->season ) {
            $item->appendChild( $this->createElement('itunes:season', $this->season ) );
        }

        return $item;
    }

}