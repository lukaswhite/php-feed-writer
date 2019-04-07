<?php

namespace Lukaswhite\FeedWriter\Entities\Disqus;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Remote
 *
 * This entity allows a comment to be related to a Disqus user.
 *
 * @package Lukaswhite\FeedWriter\Entities\Disqus
 */
class Remote extends Entity
{
    /**
     * The Disqus ID
     *
     * @var string
     */
    protected $id;

    /**
     * The avatar
     *
     * @var string|integer
     */
    protected $avatar;

    /**
     * Set the ID
     *
     * @param string|integer $id
     * @return self
     */
    public function id( $id ) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the avatar
     *
     * @param string $avatar
     * @return self
     */
    public function avatar( string $avatar ) : self
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $remote = $this->createElement( 'dsq:remote' );

        if ( $this->id ) {
            $remote->appendChild(
                $this->createElement( 'dsq:id', $this->id )
            );
        }

        if ( $this->avatar ) {
            $remote->appendChild(
                $this->createElement( 'dsq:avatar', $this->avatar )
            );
        }

        return $remote;

    }
}