<?php

namespace Lukaswhite\FeedWriter\Exceptions;


class InvalidGeoRSSWhereType extends \Exception
{
    protected $message = 'Invalid value; must be one of point, line, polygon or box';
}