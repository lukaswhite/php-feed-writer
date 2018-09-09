<?php

namespace Lukaswhite\FeedWriter\Entities;

use Lukaswhite\FeedWriter\Feed;

/**
 * Class Entity
 * 
 * @package Lukaswhite\FeedWriter\Entities
 */
abstract class Entity
{
    /**
     * The feed that this entity belongs to.
     *
     * @var Feed
     */
    protected $feed;

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
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    abstract public function element( ) : \DOMElement;

    /**
     * Create an element
     *
     * @param \DOMDocument $doc
     * @param string $name
     * @param mixed $value
     * @param array $attributes
     * @return \DOMElement
     */
    protected function createElement( string $name, $value = null, array $attributes = [ ] ) : \DOMElement
    {
        $el = $this->feed->getDocument( )->createElement( $name, $value );
        if ( count( $attributes ) ) {
            foreach( $attributes as $key => $value ) {
                $el->setAttribute( $key, $value );
            }
        }
        return $el;
    }
}