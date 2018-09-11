<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait CreatesDOMElements
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait CreatesDOMElements
{
    /**
     * Create an element
     *
     * @param \DOMDocument $doc
     * @param string $name
     * @param mixed $value
     * @param array $attributes
     * @param bool $encode
     * @return \DOMElement
     */
    protected function createElement( string $name, $value = null, array $attributes = [ ], $encode = false ) : \DOMElement
    {
        if ( ! $encode ) {
            $el = $this->feed->getDocument( )->createElement( $name, $value );
        } else {
            $el = $this->feed->getDocument( )->createElement( $name );
            $el->appendChild( $this->feed->getDocument( )->createCDATASection( $value ) );
        }
        if ( count( $attributes ) ) {
            foreach( $attributes as $key => $value ) {
                $el->setAttribute( $key, $value );
            }
        }
        return $el;
    }
}