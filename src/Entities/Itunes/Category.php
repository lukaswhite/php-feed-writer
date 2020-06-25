<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

use Lukaswhite\FeedWriter\Traits\Itunes\HasCategories;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\Media
 */
class Category extends \Lukaswhite\FeedWriter\Entities\Atom\Category
{
    use HasCategories;
    /**
     * @var string
     */
    protected $text;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $category = $this->createElement( 'itunes:category' );

        if ( $this->text ) {
            $category->setAttribute( 'text', $this->text );
        }

        $this->addCategoryElements( $category );

        return $category;
    }

    /**
     * @param string $text
     * @return Category
     */
    public function text( string $text ) : self
    {
        $this->text = $text;
        return $this;
    }
}