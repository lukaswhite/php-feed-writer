<?php

namespace Lukaswhite\FeedWriter\Traits;

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
        $this->categories = array_map(
            function( $category ) {
                $this->addCategory( $category );
            },
            $categories
        );
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
        $this->categories[ ] = [
            'name'      =>  $category,
            'domain'    =>  $domain,
        ];
        return $this;
    }

    /**
     * Add the dimensions to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addCategoryElements( \DOMElement $el ) : void
    {
        if ( count( $this->categories ) ) {
            foreach( $this->categories as $category ) {
                $el = $this->feed->getDocument( )->createElement( 'category', $category[ 'name' ] );
                if ( isset( $category[ 'domain' ] ) && ! empty( $category[ 'domain' ] ) ) {
                    $el->setAttribute( 'domain', $category[ 'domain' ] );
                }
            }
        }
    }
}