<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasImage
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasImage
{
    /**
     * An optional (but recommended) image for this item / channel
     *
     * @var string
     */
    protected $image;

    /**
     * Set the image
     *
     * @param string $image
     * @return $this
     */
    public function image( string $image ) : self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Add the author to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addImageElement( \DOMElement $el ) : void
    {
        if ( $this->image ) {
            $el->appendChild( $this->createElement(
                'itunes:image',
                '',
                [
                    'href'  =>  $this->image
                ] )
            );
        }
    }
}