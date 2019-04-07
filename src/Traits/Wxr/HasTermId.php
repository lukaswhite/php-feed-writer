<?php

namespace Lukaswhite\FeedWriter\Traits\Wxr;

/**
 * Trait HasTermId
 *
 * @package Lukaswhite\FeedWriter\Traits\Wxr
 */
trait HasTermId
{
    /**
     * The term ID
     *
     * @var string
     */
    protected $termId;

    /**
     * Set the term ID
     *
     * @param integer $termId
     * @return self
     */
    public function termId( int $termId )
    {
        $this->termId = $termId;
        return $this;
    }

    /**
     * Add the term ID to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addTermIdElement( \DOMElement $el ) : void
    {
        if ( $this->termId ) {
            $el->appendChild( $this->createElement( 'wp:term_id', $this->termId ) );
        }
    }
}