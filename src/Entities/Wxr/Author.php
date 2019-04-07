<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;

/**
 * Class Author
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
class Author extends \Lukaswhite\FeedWriter\Entities\Entity
{
    /**
     * The ID of the author
     *
     * @var integer
     */
    protected $id;

    /**
     * The author's login
     *
     * @var string
     */
    protected $login;

    /**
     * The author's e-mail address
     *
     * @var string
     */
    protected $email;

    /**
     * The author's first name
     *
     * @var string
     */
    protected $firstName;

    /**
     * The author's last name
     *
     * @var string
     */
    protected $lastName;

    /**
     * The author's display name
     *
     * @var string
     */
    protected $displayName;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $author = $this->createElement( 'wp:author' );

        if ( $this->id ) {
            $author->appendChild(
                $this->createElement('wp:author_id', $this->id )
            );
        }

        if ( $this->login ) {
            $author->appendChild(
                $this->createElement('wp:author_login', $this->login )
            );
        }

        if ( $this->email ) {
            $author->appendChild(
                $this->createElement('wp:author_email', $this->email )
            );
        }

        if ( $this->displayName ) {
            $author->appendChild(
                $this->createElement('wp:author_display_name', $this->displayName )
            );
        }

        if ( $this->firstName ) {
            $author->appendChild(
                $this->createElement('wp:author_first_name', $this->firstName )
            );
        }

        if ( $this->firstName ) {
            $author->appendChild(
                $this->createElement('wp:author_last_name', $this->lastName )
            );
        }

        return $author;
    }

    /**
     * Set the author's ID
     *
     * @param mixed $id
     * @return self
     */
    public function id( $id ) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the author's login
     *
     * @param string $login
     * @return self
     */
    public function login( string $login ) : self
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Set the author's e-mail address
     *
     * @param string $email
     * @return self
     */
    public function email( string $email ) : self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set the author's first name
     *
     * @param string $firstName
     * @return self
     */
    public function firstName( string $firstName ) : self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Set the author's last name
     *
     * @param string $lastName
     * @return self
     */
    public function lastName( string $lastName ) : self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Set the author's display name
     *
     * @param string $displayName
     * @return self
     */
    public function displayName( string $displayName ) : self
    {
        $this->displayName = $displayName;
        return $this;
    }
}