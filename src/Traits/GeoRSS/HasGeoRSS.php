<?php

namespace Lukaswhite\FeedWriter\Traits\GeoRSS;
use Lukaswhite\FeedWriter\Entities\GeoRSS\GeoRSS;
use Lukaswhite\FeedWriter\Entities\GeoRSS\Line;
use Lukaswhite\FeedWriter\Entities\GeoRSS\Location;
use Lukaswhite\FeedWriter\Entities\GeoRSS\Point;
use Lukaswhite\FeedWriter\Entities\GeoRSS\Polygon;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;

/**
 * Trait HasGeoRSS
 *
 * @package Lukaswhite\FeedWriter\Traits\GeoRSS
 */
trait HasGeoRSS
{
    /**
     * The GeoRSS helper
     *
     * @var GeoRSS
     */
    protected $geoRSS;

    /**
     * Get the GeoRSS helper
     *
     * @return GeoRSS
     */
    public function geoRSS( )
    {
        if ( ! $this->geoRSS ) {
            $this->geoRSS = new GeoRSS( $this->feed );
        }
        return $this->geoRSS;
    }

}