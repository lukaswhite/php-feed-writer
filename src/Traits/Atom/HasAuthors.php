<?php

namespace Lukaswhite\FeedWriter\Traits\Atom;
use Lukaswhite\FeedWriter\Entities\Atom\Person;

/**
 * Trait HasAuthors
 *
 * @package Lukaswhite\FeedWriter\Traits\Atom
 */
trait HasAuthors
{
    /**
     * The authors of this entry / channel
     *
     * @var array
     */
    protected $authors = [ ];

    /**
     * Add an author
     *
     * @return Person
     */
    public function addAuthor( )
    {
        $author = ( new Person( $this->feed ) )->tagName( 'author' );
        $this->authors[ ] = $author;
        return $author;
    }
    /**
    * Add the authors to the specified element.
    *
    * @param \DOMElement $el
    * @return void
    */
    protected function addAuthorElements( \DOMElement $el ) : void
    {
        if ( count( $this->authors ) ) {
            foreach( $this->authors as $author ) {
                /** @var Person $author */
                $el->appendChild( $author->element( ) );
            }
        }
    }
}