<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasBlock
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasBlock
{
    /**
     * Whether to block this item / channel from appearing in the iTunes Store
     * podcast directory.
     *
     * @var string
     */
    protected $block = false;

    /**
     * Specify whether to block this item / channel from appearing in the iTunes Store
     * podcast directory.
     *
     * @param bool $value
     * @return $this
     */
    public function block( $value = true ) : self
    {
        $this->block = $value;
        return $this;
    }

    /**
     * Optionally add the block element
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addBlockElement( \DOMElement $el ) : void
    {
        if ( $this->block ) {
            $el->appendChild( $this->createElement( 'itunes:block', 'Yes' ) );
        }
    }
}