<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;

/**
 * Class Meta
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
abstract class Meta extends \Lukaswhite\FeedWriter\Entities\Entity
{
    /**
     * The tag name
     *
     * @var string
     */
    protected $tagName;

    /**
     * The key
     *
     * @var string
     */
    protected $key;

    /**
     * The value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $meta = $this->createElement( $this->tagName );

        if ( $this->key ) {
            $meta->appendChild(
                $this->createElement('wp:meta_key', $this->key )
            );
        }

        if ( $this->value ) {
            $meta->appendChild(
                $this->createElement('wp:meta_value', $this->value )
            );
        }

        return $meta;
    }

    /**
     * Set the key
     *
     * @param string $key
     * @return self
     */
    public function key( string $key ) : self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Set the value
     *
     * @param mixed $value
     * @return self
     */
    public function value( $value ) : self
    {
        $this->value = $value;
        return $this;
    }

}