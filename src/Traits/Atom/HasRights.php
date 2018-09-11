<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;

use Lukaswhite\FeedWriter\Entities\Atom\Text;

/**
 * Trait HasRights
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasRights
{
    /**
     * The (copy)rights
     *
     * @var Text
     */
    protected $rights;

    /**
     * Set the (copy) rights
     *
     * @param string $rights
     * @param string $type
     * @param bool $encode
     * @return $this
     */
    public function rights( string $rights, $type = null, $encode = false ) : self
    {
        $this->rights = ( new Text( $this->feed ) )
            ->tagName( 'rights')
            ->content( $rights )
            ->encode( $encode );

        // Set the type if supplied; otherwise it'll attempt to guess
        if ( $type ) {
            $this->rights->type( $type );
        }

        return $this;
    }

    /**
    * Add the updated date/time to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addRightsElement( \DOMElement $el ) : void
    {
        if ( $this->rights ) {
            $el->appendChild( $this->rights->element( ) );
        }
    }
}