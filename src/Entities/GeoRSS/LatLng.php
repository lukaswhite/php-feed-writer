<?php

namespace Lukaswhite\FeedWriter\Entities\GeoRSS;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class LatLng
 *
 * @package Lukaswhite\FeedWriter\Entities\GeoRSS
 */
class LatLng
{
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
     * @return $this
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
     * @return $this
     */
    public function lng( float $lng ) : self
    {
        $this->lng = $lng;
        return $this;
    }

}