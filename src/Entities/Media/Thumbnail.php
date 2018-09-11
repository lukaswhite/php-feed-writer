<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Thumbnail
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Thumbnail extends Entity
{
    use HasDimensions;

    /**
     * The URL to the thumbnail
     *
     * @var string
     */
    protected $url;

    /**
     * The time offset in relation to the media object
     *
     * @var string
     */
    protected $time;

    /**
     * Set the URL of the thumbnail
     *
     * @param string $url
     * @return Thumbnail
     */
    public function url( string $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set the time offset in relation to the media object
     *
     * @param string|int $time
     * @return $this
     */
    public function time( $time ) : self
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $thumbnail = $this->feed->getDocument( )->createElement( 'media:thumbnail' );
        $thumbnail->setAttribute( 'url', $this->url );
        $this->addDimensionsToElement( $thumbnail );

        if ( $this->time ) {
            $thumbnail->setAttribute( 'time', $this->time );
        }

        return $thumbnail;
    }
}