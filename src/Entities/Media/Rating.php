<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Rating
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Rating extends Entity
{
    /**
     * The value of the rating
     *
     * @var string
     */
    protected $value;

    /**
     * The (optional) scheme
     *
     * @var string
     */
    protected $scheme;

    /**
     * Set the value of the rating
     *
     * @param string $value
     * @return self
     */
    public function value( string $value ) : self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set the scheme
     *
     * @param string $scheme
     * @return self
     */
    public function scheme( string $scheme ) : self
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $rating = $this->feed->getDocument( )->createElement( 'media:rating', $this->value );

        if ( $this->scheme ) {
            $rating->setAttribute( 'scheme', $this->scheme );
        }

        return $rating;
    }
}