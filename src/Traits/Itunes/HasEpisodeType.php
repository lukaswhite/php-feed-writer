<?php

namespace Lukaswhite\FeedWriter\Traits\Itunes;

/**
 * Trait HasEpisodeType
 *
 * @package Lukaswhite\FeedWriter\Traits\Itunes
 */
trait HasEpisodeType
{
    /**
     * The episode type
     *
     * @var string
     */
    protected $episodeType;

    /**
     * Set the episode type of the item
     *
     * @param string $episodeType
     * @return self
     */
    public function episodeType( string $episodeType ): self
    {
        $this->episodeType = $episodeType;
        return $this;
    }

    /**
     * @return $this
     */
    public function trailer(): self
    {
        return $this->episodeType('trailer');
    }

    /**
     * Add the episode type to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addEpisodeTypeElement( \DOMElement $el ) : void
    {
        if ( $this->episodeType ) {
            $el->appendChild( $this->createElement( 'itunes:episodeType', $this->episodeType ) );
        }
    }
}