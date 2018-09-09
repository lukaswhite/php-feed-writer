<?php

namespace Lukaswhite\FeedWriter\Entities\General;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Link
 * @package Lukaswhite\FeedWriter\Helpers
 */
class Link extends Entity
{
    /**
     * The name of the link; e.g. atom:link
     *
     * @var string
     */
    protected $name;

    /**
     * The URL
     *
     * @var string
     */
    protected $url;

    /**
     * The rel; e.g. self
     *
     * @var string
     */
    protected $rel;

    /**
     * The type; e.g. application/rss+xml
     *
     * @var string
     */
    protected $type;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $el = $this->feed->getDocument( )->createElement( $this->name );
        $el->setAttribute( 'href', $this->url );
        if ( $this->rel ) {
            $el->setAttribute( 'rel', $this->rel );
        }
        if ( $this->type ) {
            $el->setAttribute( 'type', $this->type );
        }
        return $el;
    }

    /**
     * Set the name of the link; e.g. atom:link
     *
     * @param string $name
     * @return Link
     */
    public function setName( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the link's URL
     *
     * @param string $url
     * @return Link
     */
    public function setUrl( string $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set the rel attribute of the link
     *
     * @param string $rel
     * @return Link
     */
    public function setRel( string $rel ) : self
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     * Set the (MIME) type
     *
     * @param string $type
     * @return Link
     */
    public function setType( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }
}