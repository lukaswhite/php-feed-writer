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
     * @param string $name
     * @return Credit
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $role
     * @return Credit
     */
    public function role($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @param string $scheme
     * @return Credit
     */
    public function scheme($scheme)
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