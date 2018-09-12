<?php

namespace Lukaswhite\FeedWriter\Traits;

use Lukaswhite\FeedWriter\Entities\Rss\Category;

/**
 * Trait HasCategories
 * 
 * @package Lukaswhite\FeedWriter\Traits
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
     * Set the categories
     *
     * @param ...string $categories
     * @return $this;
     */
    public function categories( ...$categories ) : self
    {
        foreach( $categories as $category ) {
            $this->addCategory( $category );
        }
        return $this;
    }

    /**
     * Add a category
     *
     * @param string $category
     * @param string $domain
     * @return $this;
     */
    public function addCategory( string $category, string $domain = null ) : self
    {
        $this->categories[ ] = ( new Category( $this->feed ) )
            ->term( $category )
            ->domain( $domain );

        return $this;
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