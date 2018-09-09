<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasSummary
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasSummary
{
    /**
     * A summary of the item / channel etc.
     *
     * @var string
     */
    protected $summary;

    /**
     * Set the summary
     *
     * @param string summary
     * @return $this
     */
    public function summary( string $summary ) : self
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Add the summary to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addSummaryElement( \DOMElement $el ) : void
    {
        if ( $this->summary ) {
            $summary = $this->feed->getDocument( )->createElement( 'itunes:summary' );
            $summary->appendChild( $this->feed->getDocument( )->createCDATASection( $this->summary ) );
            $el->appendChild( $summary );
        }
    }
}