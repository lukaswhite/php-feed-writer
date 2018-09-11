<?php

namespace Lukaswhite\FeedWriter\Traits\GeoRSS;
use Lukaswhite\FeedWriter\Entities\GeoRSS\Location;
use Lukaswhite\FeedWriter\Entities\GeoRSS\Point;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;

/**
 * Trait HasGeoRSS
 *
 * @package Lukaswhite\FeedWriter\Traits\GeoRSS
 */
trait HasPoints
{
    /**
     * The points
     *
     * @var string
     */
    protected $points;

    /**
     * Set the points
     *
     * @param string $points
     * @return self
     */
    public function points( string $points ) : self
    {
        $this->points = $points;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        return $this->createElement(
            self::TAG_NAME,
            $this->points
        );
    }
}