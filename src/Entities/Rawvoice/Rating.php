<?php

namespace Lukaswhite\FeedWriter\Entities\Rawvoice;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Subscribe
 *
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice
 */
class Rating extends Entity
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $tv;

    /**
     * @var string
     */
    protected $movie;

    /**
     * @param string $rating
     * @return Rating
     */
    public function value(string $rating): Rating
    {
        $this->value = $rating;
        return $this;
    }

    /**
     * @param string $tv
     * @return Rating
     */
    public function tv(string $tv): Rating
    {
        $this->tv = $tv;
        return $this;
    }

    /**
     * @param string $movie
     * @return Rating
     */
    public function movie(string $movie): Rating
    {
        $this->movie = $movie;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $el = $this->feed->getDocument( )->createElement( 'rawvoice:rating', $this->value );
        if ( $this->tv ) {
            $el->setAttribute('tv',$this->tv);
        }
        if ( $this->movie ) {
            $el->setAttribute('movie',$this->movie);
        }
        return $el;
    }

}