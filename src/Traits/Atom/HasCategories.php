<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;

use Lukaswhite\FeedWriter\Entities\Atom\Category;


/**
 * Trait HasCategories
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
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
     * Add a category
     *
     * @return Category
     */
    public function addCategory( ) : Category
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