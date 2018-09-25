<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\Media
 */
class Category extends \Lukaswhite\FeedWriter\Entities\Atom\Category
{
    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $category = $this->createElement( 'media:category', $this->term );

        if ( $this->scheme ) {
            $category->setAttribute( 'scheme', $this->scheme );
        }

        if ( $this->label ) {
            $category->setAttribute( 'label', $this->label );
        }

        return $category;
    }
}