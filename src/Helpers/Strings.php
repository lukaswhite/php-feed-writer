<?php

namespace Lukaswhite\FeedWriter\Helpers;

/**
 * Class Strings
 *
 * @package Lukaswhite\FeedWriter\Helpers
 */
class Strings
{
    /**
     * Determine whether the given string contains any HTML
     *
     * @param string $str
     * @return bool
     */
    public static function containsHtml( $str )
    {
        return ( $str != strip_tags( $str ) );
    }
}