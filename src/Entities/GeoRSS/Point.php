<?php

namespace Lukaswhite\FeedWriter\Entities\GeoRSS;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Point
 *
 * @package Lukaswhite\FeedWriter\Entities\GeoRSS
 */
class Point extends Location
{
    /**
     * The name of the tag to use when adding this to a feed
     */
    const TAG_NAME      =   'georss:point';

    /**
     * The latitude
     *
     * @var float
     */
    protected $lat;

    /**
     * The longitude
     *
     * @var float
     */
    protected $lng;

    /**
     * Set the latitude
     *
     * @param float $lat
     * @return Point
     */
    public function lat( float $lat ) : self
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Set the longitude
     *
     * @param float $lng
     * @return Point
     */
    public function lng( float $lng ) : self
    {
        $this->lng = $lng;
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
            sprintf( '%s %s', $this->lat, $this->lng )
        );
    }
}