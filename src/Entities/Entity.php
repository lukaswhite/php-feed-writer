<?php

namespace Lukaswhite\FeedWriter\Entities;

use Lukaswhite\FeedWriter\Feed;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;

/**
 * Class Entity
 * 
 * @package Lukaswhite\FeedWriter\Entities
 */
abstract class Entity
{
    use CreatesDOMElements;

    /**
     * The feed that this entity belongs to.
     *
     * @var Feed
     */
    protected $feed;

    /**
     * Any custom elements
     *
     * @var array
     */
    protected $elements = [ ];

    /**
     * Constructor
     *
     * @param Feed $feed
     */
    public function __construct( Feed $feed )
    {
        $this->feed = $feed;
    }

    /**
     * Create an entity belonging to this one.
     *
     * @var string $classname
     * @return Entity
     */
    protected function createEntity( string $classname ) : Entity
    {
        return new $classname( $this->feed );
    }

    /**
     * Add a custom element
     *
     * @param string $tagName
     * @param string $content
     * @param array $attributes
     * @return Element
     */
    public function addElement( string $tagName, $content = null, $attributes = [ ] )
    {
        $element = new Element( $this->feed, $tagName, $content, $attributes );
        $this->elements[ ] = $element;
        return $element;
    }

    /**
     * Add any custom elements to the provided DOMElement
     *
     * @param \DOMElement $el
     */
    protected function addElementsToDOMElement( \DOMElement $el )
    {
        if ( count( $this->elements ) ) {
            foreach( $this->elements as $element ) {
                /** @var Element $element */
                $el->appendChild( $element->element( ) );
            }
        }
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    abstract public function element( ) : \DOMElement;

}