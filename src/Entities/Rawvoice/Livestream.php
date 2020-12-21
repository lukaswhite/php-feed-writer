<?php

namespace Lukaswhite\FeedWriter\Entities\Rawvoice;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Livestream
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice
 */
abstract class Livestream extends Entity
{
    /**
     * @var \DateTime
     */
    protected $schedule;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    abstract protected function getTagName(): string;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $el = $this->feed->getDocument( )->createElement(
            sprintf('rawvoice:%s', $this->getTagName() ),
            $this->url
        );

        if ( $this->schedule ) {
            $el->setAttribute( 'schedule', $this->schedule->format( DATE_RSS ) );
        }
        if ( $this->duration ) {
            $el->setAttribute( 'duration', $this->duration );
        }
        if ( $this->type ) {
            $el->setAttribute( 'type', $this->type );
        }
        return $el;
    }

    /**
     * @param \DateTime $schedule
     * @return Livestream
     */
    public function schedule(\DateTime $schedule): Livestream
    {
        $this->schedule = $schedule;
        return $this;
    }

    /**
     * @param int $duration
     * @return Livestream
     */
    public function duration(int $duration): Livestream
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @param string $url
     * @return Livestream
     */
    public function url(string $url): Livestream
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $type
     * @return Livestream
     */
    public function type(string $type): Livestream
    {
        $this->type = $type;
        return $this;
    }

}