<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;

use Lukaswhite\FeedWriter\Entities\Atom\Person;

/**
 * Trait HasContributors
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasContributors
{
    /**
     * The contributors of this entry / channel
     *
     * @var array
     */
    protected $contributors = [ ];

    /**
     * Add a contributor
     *
     * @return Person
     */
    public function addContributor( )
    {
        $contributor = ( new Person( $this->feed ) )->tagName( 'contributor' );
        $this->contributors[ ] = $contributor;
        return $contributor;
    }
    /**
    * Add the contributors to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addContributorElements( \DOMElement $el ) : void
    {
        if ( count( $this->contributors ) ) {
            foreach( $this->contributors as $contributor ) {
                /** @var Person $contributor */
                $el->appendChild( $contributor->element( ) );
            }
        }
    }
}