<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Location
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Location extends Entity
{
    /**
     * A description of the location
     *
     * @var string
     */
    protected $description;

    /**
     * The latitude
     *
     * @var float
     */
    protected $lat;

    /**
     * The longitude
     *
     * @var float
     */
    protected $lng;

    /**
     * The start time
     *
     * @var string
     */
    protected $startTime;

    /**
     * The end time
     *
     * @var string
     */
    protected $endTime;

    /**
     * Provide a description of the scene
     *
     * @param string $description
     * @return self
     */
    public function description( string $description ) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the latitude
     *
     * @param float $lat
     * @return self
     */
    public function lat( float $lat ) : self
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Set the longitude
     *
     * @param float $lng
     * @return self
     */
    public function lng( float $lng ) : self
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * Set the start time of the scene
     *
     * @param string $startTime
     * @return self
     */
    public function startTime( string $startTime ) : self
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * Set the end time of the scene
     *
     * @param string $endTime
     * @return self
     */
    public function endTime( string $endTime ) : self
    {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $location = $this->feed->getDocument( )->createElement( 'media:location' );

        if ( $this->description ) {
            $location->setAttribute( 'description', $this->description );
        }

        if ( $this->startTime ) {
            $location->setAttribute( 'start', $this->startTime );
        }

        if ( $this->endTime ) {
            $location->setAttribute( 'end', $this->endTime );
        }

        $gmlPos = $this->createElement(
            'gml:pos',
            sprintf(
                '%s %s',
                $this->lat,
                $this->lng
            )
        );

        $point = $this->createElement( 'gml:Point' );
        $point->appendChild( $gmlPos );

        $where = $this->createElement( 'georss:where' );
        $where->appendChild( $point );

        $location->appendChild( $where );

        return $location;
    }
}