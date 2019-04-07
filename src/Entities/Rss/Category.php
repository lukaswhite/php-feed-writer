<?php

namespace Lukaswhite\FeedWriter\Entities\Rss;

/**
 * Class Category
 *
 * @package Lukaswhite\FeedWriter\Entities\Rss
 */
class Category extends \Lukaswhite\FeedWriter\Entities\General\Category
{
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
        $category = $this->createElement( 'category', $this->term );

        if ( $this->domain ) {
            $category->setAttribute( 'domain', $this->domain );
        }

        return $category;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function name( $name ) : self
    {
        $this->term = $name;
        return $this;
    }

    /**
     * @param string $domain
     * @return Category
     */
    public function domain( $domain ) : self
    {
        $this->domain = $domain;
        return $this;
    }

}