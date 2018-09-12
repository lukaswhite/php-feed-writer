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
     * The tag name of the link; e.g. link, atom:link
     *
     * @var string
     */
    protected $tagName = 'link';

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
     * The language of the referenced resource (i.e. the hreflang attribute)
     *
     * @var string
     */
    protected $language;

    /**
     * The length of the resource, in bytes
     *
     * @var int
     */
    protected $length;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $el = $this->feed->getDocument( )->createElement( $this->tagName );
        $el->setAttribute( 'href', $this->url );
        if ( $this->rel ) {
            $el->setAttribute( 'rel', $this->rel );
        }
        if ( $this->type ) {
            $el->setAttribute( 'type', $this->type );
        }
        if ( $this->language ) {
            $el->setAttribute( 'hreflang', $this->language );
        }
        if ( $this->length ) {
            $el->setAttribute( 'length', $this->length );
        }
        return $el;
    }

    /**
     * Set the name of the link; e.g. atom:link
     *
     * @param string $tagName
     * @return Link
     */
    public function tagName( string $tagName ) : self
    {
        $this->tagName = $tagName;
        return $this;
    }

    /**
     * Set the link's URL
     *
     * @param string $url
     * @return Link
     */
    public function url( string $url ) : self
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
    public function rel( string $rel ) : self
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
    public function type( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $language
     * @return Link
     */
    public function language( string $language ) : self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param int $length
     * @return Link
     */
    public function length( int $length ) : self
    {
        $this->length = $length;
        return $this;
    }


}