<?php

namespace Lukaswhite\FeedWriter\Entities\Media\Community;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class StarRating
 *
 * @package Lukaswhite\FeedWriter\Entities\Media\Community
 */
class StarRating extends Entity
{
    /**
     * The average rating
     *
     * @var float
     */
    protected $average;

    /**
     * The number of ratings
     *
     * @var int
     */
    protected $count;

    /**
     * The minimum rating
     *
     * @var int
     */
    protected $min;

    /**
     * The maximum rating
     *
     * @var int
     */
    protected $max;

    /**
     * Set the average rating
     *
     * @param float $average
     * @return self
     */
    public function average( float $average ) : self
    {
        $this->average = $average;
        return $this;
    }

    /**
     * Set the number of ratings
     *
     * @param int $count
     * @return self
     */
    public function count(int $count ) : self
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Set the maximum rating
     *
     * @param int $min
     * @return self
     */
    public function min( int $min ) : self
    {
        $this->min = $min;
        return $this;
    }

    /**
     * Set the maximum rating
     *
     * @param int $max
     * @return self
     */
    public function max( int $max ) : self
    {
        $this->max = $max;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $rating = $this->createElement( 'media:starRating' );

        if ( $this->average ) {
            $rating->setAttribute( 'average', $this->average );
        }

        if ( $this->count ) {
            $rating->setAttribute( 'count', $this->count );
        }

        if ( $this->min ) {
            $rating->setAttribute( 'min', $this->min );
        }

        if ( $this->max ) {
            $rating->setAttribute( 'max', $this->max );
        }

        return $rating;
    }

}