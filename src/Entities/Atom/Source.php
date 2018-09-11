<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\Atom\HasUpdated;

/**
 * Class Source
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Source extends Entity
{
    use HasUpdated;

    /**
     * The ID of the source
     *
     * @var string
     */
    protected $id;

    /**
     * The title of the source
     *
     * @var string
     */
    protected $title;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $source = $this->createElement( 'source' );

        if ( $this->id ) {
            $source->appendChild( $this->createElement( 'id', $this->id ) );
        }

        if ( $this->title ) {
            $source->appendChild( $this->createElement( 'title', $this->title ) );
        }

        $this->addUpdatedElement( $source );

        return $source;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function id( string $id ) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

}