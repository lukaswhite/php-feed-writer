<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;

use Lukaswhite\FeedWriter\Traits\Wxr\HasTermId;
use Lukaswhite\FeedWriter\Traits\Wxr\HasTermMeta;

/**
 * Class Term
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
class Term extends \Lukaswhite\FeedWriter\Entities\General\Category
{
    use     HasTermId
        ,   HasTermMeta;

    /**
     * The name of the term
     *
     * @var string
     */
    protected $name;

    /**
     * The taxonomy
     *
     * @var string
     */
    protected $taxonomy;

    /**
     * A description of the term
     *
     * @var string
     */
    protected $description;

    /**
     * The slug
     *
     * @var string
     */
    protected $slug;

    /**
     * The parent term
     *
     * @var Term
     */
    protected $parent;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $term = $this->createElement( 'wp:term' );

        $this->addTermIdElement( $term );

        if ( $this->taxonomy )
        {
            $term->appendChild(
                $this->createElement('wp:term_taxonomy', $this->taxonomy )
            );
        }

        if ( $this->name ) {
            $term->appendChild(
                $this->createElement('wp:term_name', $this->name )
            );
        }

        if ( $this->description ) {
            $term->appendChild(
                $this->createElement('wp:term_description', $this->description )
            );
        }

        if ( $this->slug ) {
            $term->appendChild(
                $this->createElement('wp:term_slug', $this->slug )
            );
        }

        if ( $this->parent ) {
            $term->appendChild(
                $this->createElement('wp:term_parent', $this->parent->getSlug( ) )
            );
        }

        $this->addTermMetaElements( $term );

        return $term;
    }

    /**
     * Set the name
     *
     * @param string $name
     * @return self
     */
    public function name( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the description
     *
     * @param string $description
     * @return self
     */
    public function description( string $description ) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the taxonomy
     *
     * @param string $taxonomy
     * @return self
     */
    public function taxonomy( string $taxonomy ) : self
    {
        $this->taxonomy = $taxonomy;
        return $this;
    }

    /**
     * Set the slug
     *
     * @param string $slug
     * @return self
     */
    public function slug( string $slug ) : self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get the slug
     *
     * @return string
     */
    public function getSlug( ) : ?string
    {
        return $this->slug;
    }

    /**
     * Set the parent
     *
     * @param Term $parent
     * @return self
     */
    public function parent( Term $parent ) : self
    {
        $this->parent = $parent;
        return $this;
    }
}