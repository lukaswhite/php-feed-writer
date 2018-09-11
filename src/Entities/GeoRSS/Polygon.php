<?php

namespace Lukaswhite\FeedWriter\Entities\GeoRSS;

use Lukaswhite\FeedWriter\Traits\GeoRSS\HasPoints;

/**
 * Class Polygon
 *
 * @package Lukaswhite\FeedWriter\Entities\GeoRSS
 */
class Polygon extends Location
{
    /**
     * The name of the tag to use when adding this to a feed
     */
    const TAG_NAME      =   'georss:polygon';

    use HasPoints;
}