<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait HasUrl
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasUrl
{
    /**
     * The URL
     *
     * @var string
     */
    protected $url;

    /**
     * Set the URL
     *
     * @param string $url
     * @return $this
     */
    public function url( string $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Add the URL to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addUrlElement( \DOMElement $el ) : void
    {
        if ( $this->url ) {
            $el->appendChild( $this->createElement( 'url', $this->url ) );
        }
    }
}