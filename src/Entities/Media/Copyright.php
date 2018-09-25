<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Copyright
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Copyright extends Entity
{
    /**
     * The text of the copyright notice
     *
     * @var string
     */
    protected $text;

    /**
     * An optional URL to a terms of use page or additional copyright information
     *
     * @var string
     */
    protected $url;

    /**
     * Set the text of the copyright notice
     *
     * @param string $text
     * @return self
     */
    public function text( string $text ) : self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Set the URL to a terms of use page or additional copyright information
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
            'media:copyright',
            $this->text
        );

        if ( $this->url ) {
            $status->setAttribute( 'url', $this->url );
        }

        return $status;
    }
}