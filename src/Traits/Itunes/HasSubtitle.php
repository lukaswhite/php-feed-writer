<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasSubtitle
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasSubtitle
{
    /**
     * The item / channel's subtitle
     *
     * @var string
     */
    protected $subtitle;

    /**
     * Set the subtitle
     *
     * @param string subtitle
     * @return $this
     */
    public function subtitle( string $subtitle ) : self
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * Add the subtitle to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addSubtitleElement( \DOMElement $el ) : void
    {
        if ( $this->subtitle ) {
            $el->appendChild( $this->createElement( 'itunes:subtitle', $this->subtitle ) );
        }
    }
}