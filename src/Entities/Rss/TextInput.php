<?php

namespace Lukaswhite\FeedWriter\Entities\Rss;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\General\Enclosure;
use Lukaswhite\FeedWriter\Traits\HasLink;
use Lukaswhite\FeedWriter\Traits\HasMedia;
use Lukaswhite\FeedWriter\Traits\HasPublishedDate;
use Lukaswhite\FeedWriter\Traits\HasTitleAndDescription;

/**
 * Class TextInput
 *
 * @package Lukaswhite\FeedWriter\Entities\Rss
 */
class TextInput extends Entity
{
    use HasTitleAndDescription,
        HasLink;

    /**
     * The name of the text object in the text input area.
     *
     * @var string
     */
    protected $name;

    /**
     * Set the name of the text object in the text input area.
     *
     * @param string $name
     * @return $this
     */
    public function name( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $item = $this->feed->getDocument( )->createElement( 'textInput' );

        $this->addTitleAndDescriptionElements( $item );

        $this->addLinkElement( $item );

        if ( $this->name ) {
            $item->appendChild( $this->createElement( 'name', $this->name ) );
        }

        return $item;
    }
}