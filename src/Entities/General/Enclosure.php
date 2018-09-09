<?php

namespace Lukaswhite\FeedWriter\Entities\General;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Enclosure
 *
 * @see http://cyber.harvard.edu/rss/rss.html#ltenclosuregtSubelementOfLtitemgt
 *
 * @package Lukaswhite\FeedWriter\Helpers
 */
class Enclosure extends Entity
{
    /**
     * The URL of the enclosure
     *
     * @var string
     */
    protected $url;

    /**
     * How big the enclosure is, in bytes
     *
     * @var int
     */
    protected $length;

    /**
     * The (MIME) type of the enclosure
     *
     * @var string
     */
    protected $type;

    /**
     * @param string $url
     * @return $this
     */
    public function url( string $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set the length; i.e. the size, in bytes
     *
     * @param int $length
     * @return $this
     */
    public function length( int $length ) : self
    {
        $this->length = $length;
        return $this;
    }

    /**
     * Set the (MIME) type
     *
     * @param string $type
     * @return $this
     */
    public function type( string $type )  : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Create the DOM element that represents this entity
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $enclosure = $this->feed->getDocument( )->createElement( 'enclosure' );
        $enclosure->setAttribute( 'url', $this->url );
        $enclosure->setAttribute( 'length', $this->length );
        $enclosure->setAttribute( 'type', $this->type );

        return $enclosure;
    }

}