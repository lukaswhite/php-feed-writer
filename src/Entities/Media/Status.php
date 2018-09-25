<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Status
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Status extends Entity
{
    /**
     * Class constants
     */
    const ACTIVE        =   'active';
    const BLOCKED       =   'blocked';
    const DELETED       =   'deleted';

    /**
     * The state
     *
     * @var string
     */
    protected $state;

    /**
     * The reason; either text or a URL
     *
     * @var string
     */
    protected $reason;

    /**
     * Set the state of the rating
     *
     * @param string $state
     * @return self
     */
    public function state( string $state ) : self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Set the reason
     *
     * @param string $reason
     * @return self
     */
    public function reason( string $reason ) : self
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $status = $this->feed->getDocument( )->createElement(
            'media:status',
            null
        );

        $status->setAttribute( 'state', $this->state );
        $status->setAttribute( 'reason', $this->reason );
        return $status;
    }
}