<?php

namespace Lukaswhite\FeedWriter\Entities\GeoRSS;

use Lukaswhite\FeedWriter\Traits\GeoRSS\HasPoints;

/**
 * Class Line
 *
 * @package Lukaswhite\FeedWriter\Entities\GeoRSS
 */
class Line extends Location
{
    /**
     * The name of the tag to use when adding this to a feed
     */
    const TAG_NAME      =   'georss:line';

    use HasPoints;
}