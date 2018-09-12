<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Category extends \Lukaswhite\FeedWriter\Entities\General\Category
{
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
        $category = parent::element( );

        if ( $this->scheme ) {
            $category->setAttribute( 'scheme', $this->scheme );
        }

        if ( $this->label ) {
            $category->setAttribute( 'label', $this->label );
        }

        return $category;
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

    /**
     * @param string $scheme
     * @return Category
     */
    public function scheme( string $scheme ) : self
    {
        $this->scheme = $scheme;
        return $this;
    }

}