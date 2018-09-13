<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Scene
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Scene extends Entity
{
    /**
     * The title of the scene
     *
     * @var string
     */
    protected $title;

    /**
     * A description of the scene
     *
     * @var string
     */
    protected $description;

    /**
     * The start time of the scene
     *
     * @var string
     */
    protected $startTime;

    /**
     * The end time of the scene
     *
     * @var string
     */
    protected $endTime;

    /**
     * Set the title of the scene
     *
     * @param string $title
     * @return self
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

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
        $scene = $this->feed->getDocument( )->createElement( 'media:scene' );

        if ( $this->title ) {
            $scene->appendChild( $this->createElement( 'sceneTitle', $this->title ) );
        }

        if ( $this->description ) {
            $scene->appendChild( $this->createElement('sceneDescription', $this->description ) );
        }

        if ( $this->startTime ) {
            $scene->appendChild( $this->createElement('sceneStartTime', $this->startTime ) );
        }

        if ( $this->endTime ) {
            $scene->appendChild( $this->createElement('sceneEndTime', $this->endTime ) );
        }

        return $scene;
    }
}