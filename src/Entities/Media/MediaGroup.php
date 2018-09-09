<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasMedia;

/**
 * Class MediaGroup
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class MediaGroup extends Entity
{
    use HasMedia;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $group = $this->feed->getDocument( )->createElement( 'media:group' );

        $this->addMediaElements( $group );

        return $group;
    }
}