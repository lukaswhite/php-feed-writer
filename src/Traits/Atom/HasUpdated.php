<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;

/**
 * Trait HasUpdated
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasUpdated
{
    /**
     * The date and time that this entry/channel was updated
     *
     * @var \DateTime
     */
    protected $updated;

    /**
     * Specify the date and time that this entry/channel was updated
     *
     * @param \DateTime $updated
     * @return $this
     */
    public function updated( \DateTime $updated ) : self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
    * Add the updated date/time to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addUpdatedElement( \DOMElement $el ) : void
    {
        if ( $this->updated ) {
            $el->appendChild(
                $this->createElement(
                    'updated',
                    $this->updated->format( DATE_ATOM )
                )
            );
        }
    }
}