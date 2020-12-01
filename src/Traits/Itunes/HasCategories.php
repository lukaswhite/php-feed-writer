<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

use Lukaswhite\FeedWriter\Entities\Itunes\Category;

/**
 * Trait HasAuthor
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasCategories
{
    /**
     * @var array
     */
    protected $categories = [];

    /**
     * Add a category
     *
     * @return Category
     */
    public function addCategory(): Category
    {
        $category = $this->createEntity(Category::class);
        $this->categories[] = $category;
        /** @var Category $category */
        return $category;
    }

    /**
     * Add the author to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addCategoriesElements( \DOMElement $el ) : void
    {
        if ( $this->author ) {
            $el->appendChild( $this->createElement( 'itunes:author', $this->author ) );
        }
    }
}