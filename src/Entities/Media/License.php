<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class License
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class License extends Entity
{
    /**
     * The name of the license
     *
     * @var string
     */
    protected $name;

    /**
     * The type; e.g. text/html
     *
     * @var string
     */
    protected $type;

    /**
     * The URL to the license
     *
     * @var string
     */
    protected $url;

    /**
     * Set the name of the license
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
     * Set the type of license; e.g. text/html
     *
     * @param string $type
     * @return self
     */
    public function type( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set the URL of the license
     *
     * @param string $url
     * @return self
     */
    public function url( string $url ) : self
    {
        $this->url = $url;
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
            'media:license',
            $this->name
        );

        $status->setAttribute( 'type', $this->type );
        $status->setAttribute( 'href', $this->url );
        return $status;
    }
}