<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Embed
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Embed extends Entity
{
    use HasDimensions;

    /**
     * The URL
     *
     * @var string
     */
    protected $url;

    /**
     * The additional parameters
     *
     * @var array
     */
    protected $params = [ ];


    /**
     * Sets the URL of the embed
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
     * Set any additional parameters
     *
     * @param array $params
     * @return self
     */
    public function params( array $params ) : self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $embed = $this->feed->getDocument( )->createElement( 'media:embed' );

        $embed->setAttribute( 'url', $this->url );

        $this->addDimensionsToElement( $embed );

        if ( count( $this->params ) ) {
            foreach( $this->params as $name => $value ) {
                $embed->appendChild(
                    $this->createElement(
                        'media:param',
                        $value,
                        [
                            'name'  =>  $name
                        ]
                    )
                );
            }
        }

        return $embed;
    }

}