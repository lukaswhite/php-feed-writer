<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasSummary
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasExplicit
{
    /**
     * The explicit value
     *
     * @var string
     */
    protected $explicit;

    /**
     * Set the explicit value
     *
     * @param string $explicit
     * @return $this
     */
    public function explicit( string $explicit ) : self
    {
        $this->explicit = $explicit;
        return $this;
    }

    /**
     * Add the explicit element to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addExplicitElement( \DOMElement $el ) : void
    {
        if ( $this->explicit ) {
            $el->appendChild( $this->createElement( 'itunes:explicit', $this->explicit ) );
        }
    }
}