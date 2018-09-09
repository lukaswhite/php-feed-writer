<?php

namespace Lukaswhite\FeedWriter\Traits;

/**
 * Trait HasTitleAndDescription
 *
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasTitleAndDescription
{
    /**
     * The title
     *
     * @var string
     */
    protected $title;

    /**
     * The description
     *
     * @var string
     */
    protected $description;

    /**
     * Set the title
     *
     * @param string $title
     * @return $this
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the description
     *
     * @param string $description
     * @return $this
     */
    public function description( string $description ) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Add the title and description to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addTitleAndDescriptionElements( \DOMElement $el ) : void
    {
        if ( $this->title ) {
            $el->appendChild( $this->createElement( 'title', $this->title ) );
        }

        if ( $this->description ) {
            $description = $this->feed->getDocument( )->createElement( 'description' );
            $description->appendChild( $this->feed->getDocument( )->createCDATASection( $this->description ) );
            $el->appendChild( $description );
        }
    }
}