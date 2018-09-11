<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;

/**
 * Trait HasId
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasId
{
    /**
     * The ID of the entry
     *
     * @var string
     */
    protected $id;

    /**
     * Set the ID of the entry
     *
     * @param string $id
     * @return $this
     */
    public function id( string $id ) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
    * Add the updated date/time to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addIdElement( \DOMElement $el ) : void
    {
        if ( $this->id ) {
            $el->appendChild(
                $this->createElement(
                    'id',
                    $this->id
                )
            );
        }
    }
}