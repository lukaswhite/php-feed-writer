<?php

namespace Lukaswhite\FeedWriter\Traits\Wxr;

use Lukaswhite\FeedWriter\Entities\Wxr\Category;

/**
 * Trait HasCategories
 * 
 * @package Lukaswhite\FeedWriter\Traits\Wxr
 */
trait HasCategories
{
    /**
     * The categories
     *
     * @var array
     */
    protected $categories = [ ];

    /**
     * Add a category
     *
     * @return Category
     */
    public function addCategory( )
    {
        $category = new Category( $this->feed );
        $this->categories[ ] = $category;
        return $category;
    }

    /**
     * Add the categories to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addCategoryElements( \DOMElement $el ) : void
    {
        if ( count( $this->categories ) ) {
            foreach( $this->categories as $category ) {
                /** @var Category $category */
                $el->appendChild( $category->element( ) );
            }
        }
    }
}