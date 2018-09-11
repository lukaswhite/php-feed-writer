<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\General\Link;

/**
 * Class Enclosure
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Enclosure extends \Lukaswhite\FeedWriter\Entities\General\Enclosure
{
    /**
     * Convert this enclosure into a link.
     *
     * @return Link
     */
    public function toLink( )
    {
        return ( new Link( $this->feed ) )
            ->url( $this->url )
            ->type( $this->type )
            ->length( $this->length )
            ->rel( 'enclosure' );
    }
}