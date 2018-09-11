<?php

namespace Lukaswhite\FeedWriter\Entities;

use Lukaswhite\FeedWriter\Feed;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;

/**
 * Class Element
 *
 * Represents an element in a feed-related entity. It effectively corresponds to a DOMElement,
 * but it's designed to be a little friendlier to work with.
 * 
 * @package Lukaswhite\FeedWriter\Entities
 */
class Element extends Entity
{
    use CreatesDOMElements;

    /**
     * The feed
     *
     * @var Feed
     */
    protected $feed;

    /**
     * The tag name
     *
     * @var string
     */
    protected $tagName;

    /**
     * The namespace
     *
     * @var string
     */
    protected $namespace;

    /**
     * The content of the element
     *
     * @var string
     */
    protected $content;

    /**
     * Attributes to attach to the element
     *
     * @var array
     */
    protected $attributes = [ ];

    /**
     * Element constructor.
     *
     * @param string $tagName
     * @param string $content
     * @param array $attributes
     * @param array $children
     */
    public function __construct( Feed $feed, string $tagName, $content, $attributes = [ ] )
    {
        parent::__construct( $feed );
        $this->setTagName( $tagName );
        $this->content = $content;
        $this->attributes = $attributes;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $el = $this->createElement(
            $this->getQualifiedTagName( ),
            $this->content,
            $this->attributes
        );

        $this->addElementsToDOMElement( $el );

        return $el;
    }

    /**
     * Set the tag name
     *
     * @param string $tagName
     */
    protected function setTagName( string $tagName ) : void
    {
        if ( strpos( $tagName, ':' ) > -1 ) {
            $parts = explode(':', $tagName);
            $this->namespace = $parts[ 0 ];
            $this->tagName = $parts[ 1 ];
        } else {
            $this->tagName = $tagName;
        }
    }

    /**
     * Get the qualified tag name
     *
     * @return string
     */
    protected function getQualifiedTagName(  ) : string
    {
        return ( $this->namespace ) ? sprintf( '%s:%s', $this->namespace, $this->tagName )
            : $this->tagName;
    }
}