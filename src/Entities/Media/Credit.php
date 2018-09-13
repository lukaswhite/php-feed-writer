<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Credit
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Credit extends Entity
{
    /**
     * The name of the entity being credited
     *
     * @var string
     */
    protected $name;

    /**
     * The role the entity played
     *
     * @var string
     */
    protected $role;

    /**
     * The URI that identifies the role scheme
     *
     * @var string
     */
    protected $scheme;

    /**
     * Set the name
     *
     * @param string $name
     * @return self
     */
    public function name( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the role
     *
     * @param string $role
     * @return self
     */
    public function role( string $role ) : self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Set the scheme
     *
     * @param string $scheme
     * @return self
     */
    public function scheme( string $scheme ) : self
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $credit = $this->feed->getDocument( )->createElement( 'media:credit', $this->name );

        if ( $this->role ) {
            $credit->setAttribute( 'role', $this->role );
        }

        if ( $this->scheme ) {
            $credit->setAttribute( 'scheme', $this->scheme );
        }

        return $credit;
    }
}