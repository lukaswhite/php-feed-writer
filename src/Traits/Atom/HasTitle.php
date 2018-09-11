<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;

use Lukaswhite\FeedWriter\Entities\Atom\Text;

/**
 * Trait HasTitle
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasTitle
{
    /**
     * The title
     *
     * @var Text
     */
    protected $title;

    /**
     * Set the title
     *
     * @param string $title
     * @param string $type
     * @param bool $encode
     * @return $this
     */
    public function title( string $title, $type = null, $encode = false ) : self
    {
        $this->title = ( new Text( $this->feed ) )
            ->tagName( 'title')
            ->content( $title )
            ->encode( $encode );

        // Set the type if supplied; otherwise it'll attempt to guess
        if ( $type ) {
            $this->title->type( $type );
        }

        return $this;
    }

    /**
    * Add the title to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addTitleElement( \DOMElement $el ) : void
    {
        if ( $this->title ) {
            $el->appendChild( $this->title->element( ) );
        }
    }
}