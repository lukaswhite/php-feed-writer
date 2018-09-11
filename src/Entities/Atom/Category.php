<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
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
     * The scheme, which identifies the categorization scheme via a URI
     *
     * @var string
     */
    protected $scheme;

    /**
     * A human-readable label for display
     *
     * @var string
     */
    protected $label;

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

        if ( $this->scheme ) {
            $category->setAttribute( 'scheme', $this->scheme );
        }

        if ( $this->label ) {
            $category->setAttribute( 'label', $this->label );
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

    /**
     * @param string $scheme
     * @return Category
     */
    public function scheme( string $scheme ) : self
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @param string $label
     * @return Category
     */
    public function label( string $label ) : self
    {
        $this->label = $label;
        return $this;
    }





}