<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;
use Lukaswhite\FeedWriter\Entities\Atom\Person;
use Lukaswhite\FeedWriter\Entities\General\Link;

/**
 * Trait HasLinks
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasLinks
{
    /**
     * The links
     *
     * @var array
     */
    protected $links = [ ];

    /**
     * Add a link
     *
     * @return Link
     */
    public function addLink( )
    {
        $link = ( new Link( $this->feed ) )->tagName( 'link' );
        $this->links[ ] = $link;
        return $link;
    }
    /**
    * Add the links to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addLinkElements( \DOMElement $el ) : void
    {
        if ( count( $this->links ) ) {
            foreach( $this->links as $link ) {
                /** @var Link $link */
                $el->appendChild( $link->element( ) );
            }
        }
    }
}