<?php

namespace Lukaswhite\FeedWriter\Entities\General;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\General
 */
class Category extends Entity
{
    /**
     * The term, which identifies this category
     *
     * @var string
     */
    protected $term;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $category = $this->createElement( 'category' );

        if ( $this->term ) {
            $category->setAttribute( 'term', $this->term );
        }

        return $category;
    }

    /**
     * @param string $term
     * @return Category
     */
    public function term( string $term ) : self
    {
        $this->term = $term;
        return $this;
    }

}