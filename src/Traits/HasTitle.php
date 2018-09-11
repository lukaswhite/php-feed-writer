<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait HasTitle
 *
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasTitle
{
    /**
     * The title
     *
     * @var string
     */
    protected $title;

    /**
     * Set the title
     *
     * @param string $title
     * @return $this
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Add the title to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addTitleElement( \DOMElement $el ) : void
    {
        if ( $this->title ) {
            $el->appendChild( $this->createElement( 'title', $this->title ) );
        }
    }
}