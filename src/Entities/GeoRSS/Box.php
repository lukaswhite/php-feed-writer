<?php

namespace Lukaswhite\FeedWriter\Entities\GeoRSS;

use Lukaswhite\FeedWriter\Traits\GeoRSS\HasPoints;

/**
 * Class Box
 *
 * @package Lukaswhite\FeedWriter\Entities\GeoRSS
 */
class Box extends Location
{
    /**
     * The name of the tag to use when adding this to a feed
     */
    const TAG_NAME      =   'georss:box';

    use HasPoints;
}