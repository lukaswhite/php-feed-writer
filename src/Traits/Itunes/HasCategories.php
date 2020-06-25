<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

use Lukaswhite\FeedWriter\Entities\Itunes\Category;


/**
 * Trait HasCategories
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasCategories
{
    /**
     * The categories for this entry / channel
     *
     * @var array
     */
    protected $categories = [ ];

    /**
     * Add a contributor
     *
     * @return Category
     */
    public function addCategory( )
    {
        $category = ( new Category( $this->feed ) );
        $this->categories[ ] = $category;
        return $category;
    }

    /**
    * Add the authors to the specified element.
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