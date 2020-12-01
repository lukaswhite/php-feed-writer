<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

use Lukaswhite\FeedWriter\Entities\Element;

/**
 * Class Item
 *
 * @package Lukaswhite\FeedWriter\Entities\Itunes
 */
class Category extends \Lukaswhite\FeedWriter\Entities\General\Category
{
    /**
     * @var array
     */
    protected $subCategories = [];

    /**
     * @param string ...$children
     * @return self
     */
    public function children(string ...$children): self
    {
        $this->subCategories = $children;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $category = $this->createElement( 'itunes:category' );
        $category->setAttribute( 'text', $this->term );

        if ( count( $this->subCategories ) ) {
            foreach( $this->subCategories as $subCategory ) {
                $subCategoryEl = $this->createElement( 'itunes:category' );
                $subCategoryEl->setAttribute( 'text', $subCategory );
                $category->appendChild($subCategoryEl);
            }
        }

        return $category;
    }
}