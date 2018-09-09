<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasAuthor
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasAuthor
{
    /**
     * The item / channel's author
     *
     * @var string
     */
    protected $author;

    /**
     * Set the subtitle
     *
     * @param string $author
     * @return $this
     */
    public function author( string $author ) : self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Add the author to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addAuthorElement( \DOMElement $el ) : void
    {
        if ( $this->author ) {
            $el->appendChild( $this->createElement( 'itunes:author', $this->author ) );
        }
    }
}