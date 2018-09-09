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
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $thumbnail = $this->feed->getDocument( )->createElement( 'media:thumbnail' );
        $thumbnail->setAttribute( 'url', $this->url );
        $this->addDimensionsElements( $thumbnail );

        return $thumbnail;
    }
}