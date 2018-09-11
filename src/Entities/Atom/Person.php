<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Person
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Person extends Entity
{
    /**
     * The name of the tag to use; e.g. author, contributor
     *
     * @var string
     */
    protected $tagName = 'author';

    /**
     * The person's nane
     *
     * @var string
     */
    protected $name;

    /**
     * The person's e-mail address
     *
     * @var string
     */
    protected $email;

    /**
     * A URI related to the person
     *
     * @var string
     */
    protected $uri;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $person = $this->createElement( $this->tagName );

        if ( $this->name ) {
            $person->appendChild( $this->createElement( 'name', $this->name ) );
        }

        if ( $this->email ) {
            $person->appendChild( $this->createElement( 'email', $this->email ) );
        }

        if ( $this->name ) {
            $person->appendChild( $this->createElement( 'uri', $this->uri ) );
        }

        return $person;
    }

    /**
     * @param string $tagName
     * @return Person
     */
    public function tagName( string $tagName ) : self
    {
        $this->tagName = $tagName;
        return $this;
    }

    /**
     * @param string $name
     * @return Person
     */
    public function name( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $email
     * @return Person
     */
    public function email( string $email ) : self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $uri
     * @return Person
     */
    public function uri( string $uri ) : self
    {
        $this->uri = $uri;
        return $this;
    }


}