<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;

use Lukaswhite\FeedWriter\Traits\Wxr\HasTermId;
use Lukaswhite\FeedWriter\Traits\Wxr\HasTermMeta;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
class Category extends \Lukaswhite\FeedWriter\Entities\General\Category
{
    use     HasTermId
        ,   HasTermMeta;

    /**
     * The name of the category
     *
     * @var string
     */
    protected $name;

    /**
     * A description of the category
     *
     * @var string
     */
    protected $description;

    /**
     * The "nice" name
     *
     * @var string
     */
    protected $niceName;

    /**
     * The slug
     *
     * @var string
     */
    protected $slug;

    /**
     * The parent category
     *
     * @var Category
     */
    protected $parent;

    /**
     * The domain, which identifies the categorization scheme via a URI
     *
     * @var string
     */
    protected $domain;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $category = $this->createElement( 'wp:category' );

        $this->addTermIdElement( $category );

        if ( $this->name ) {
            $category->appendChild(
                $this->createElement('wp:cat_name', $this->name )
            );
        }

        if ( $this->description ) {
            $category->appendChild(
                $this->createElement('wp:category_description', $this->description )
            );
        }

        if ( $this->niceName ) {
            $category->appendChild(
                $this->createElement('wp:category_nicename', $this->niceName )
            );
        }

        if ( $this->parent ) {
            $category->appendChild(
                $this->createElement('wp:category_parent', $this->parent->getSlug( ) )
            );
        }

        $this->addTermMetaElements( $category );

        return $category;
    }

    /**
     * Set the name
     *
     * @param string $name
     * @return self
     */
    public function name( $name ) : self
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
    public function description( $description ) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the nice name
     *
     * @param string $niceName
     * @return self
     */
    public function niceName( $niceName ) : self
    {
        $this->niceName = $niceName;
        return $this;
    }

    /**
     * Set the domain
     *
     * @param string $domain
     * @return self
     */
    public function domain( string $domain ) : self
    {
        $this->domain = $domain;
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
     * @param Category $parent
     * @return self
     */
    public function parent( Category $parent ) : self
    {
        $this->parent = $parent;
        return $this;
    }


}