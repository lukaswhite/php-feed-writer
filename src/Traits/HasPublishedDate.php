<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait HasPublishedDate
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasPublishedDate
{
    /**
     * The publication date
     *
     * @var \DateTime
     */
    protected $pubDate;

    /**
     * Set the published date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function pubDate( \DateTime $date ) : self
    {
        $this->pubDate = $date;
        return $this;
    }

    /**
     * Add the published date to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addPublishedDateElement( \DOMElement $el ) : void
    {
        if ( $this->pubDate ) {
            $el->appendChild( $this->createElement(
                'pubDate',
                $this->pubDate->format( DATE_RSS ) )
            );
        }
    }

}