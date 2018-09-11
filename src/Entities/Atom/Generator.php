<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Generator
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Generator extends Entity
{
    /**
     * The name of the generator
     *
     * @var string
     */
    protected $name;

    /**
     * A URI for the generator
     *
     * @var string
     */
    protected $uri;

    /**
     * The version
     *
     * @var string
     */
    protected $version;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $generator = $this->createElement( 'generator', $this->name );

        if ( $this->uri ) {
            $generator->setAttribute( 'uri', $this->uri );
        }

        if ( $this->version ) {
            $generator->setAttribute( 'version', $this->version );
        }

        return $generator;
    }

    /**
     * @param string $name
     * @return Generator
     */
    public function name( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $uri
     * @return Generator
     */
    public function uri( string $uri ) : self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $version
     * @return Generator
     */
    public function version( string $version ) : self
    {
        $this->version = $version;
        return $this;
    }





}