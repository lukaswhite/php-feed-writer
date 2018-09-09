<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait HasDimensions
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasDimensions
{
    /**
     * The width, in pixels, of the entity
     *
     * @var int
     */
    protected $width;

    /**
     * The height, in pixels, of the entity
     *
     * @var int
     */
    protected $height;

    /**
     * Set the width
     *
     * @param int $width
     * @return $this
     */
    public function width( int $width ) : self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Set the height
     *
     * @param int $height
     * @return $this
     */
    public function height( int $height ) : self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Add the dimensions to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addDimensionsToElement( \DOMElement $el ) : void
    {
        if ( $this->width ) {
            $el->setAttribute( 'width', $this->width );
        }

        if ( $this->height ) {
            $el->setAttribute( 'height', $this->height );
        }
    }

    /**
     * Add the dimensions as elements
     *
     * @return void
     */
    protected function addDimensionsElements( \DOMElement $el ) : void
    {

        if ( $this->width ) {
            $el->appendChild( $this->createElement( 'width', $this->width ) );
        }

        if ( $this->height ) {
            $el->appendChild( $this->createElement( 'height', $this->height ) );
        }
    }
}