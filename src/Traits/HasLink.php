<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait HasLink
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasLink
{
    /**
     * The link (URL)
     *
     * @var string
     */
    protected $link;

    /**
     * Set the link (URI)
     *
     * @param string $link
     * @return $this
     */
    public function link( string $link ) : self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Add the link to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addLinkElement( \DOMElement $el ) : void
    {
        if ( $this->link ) {
            $el->appendChild( $this->createElement( 'link', $this->link ) );
        }
    }
}