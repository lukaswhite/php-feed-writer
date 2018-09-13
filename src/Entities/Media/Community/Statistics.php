<?php

namespace Lukaswhite\FeedWriter\Entities\Media\Community;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Statistics
 *
 * @package Lukaswhite\FeedWriter\Entities\Media\Community
 */
class Statistics extends Entity
{
    /**
     * The number of views
     *
     * @var int
     */
    protected $views;

    /**
     * The number of favorites
     *
     * @var int
     */
    protected $favorites;

    /**
     * Set the number of views
     *
     * @param int $views
     * @return self
     */
    public function views( int $views ) : self
    {
        $this->views = $views;
        return $this;
    }

    /**
     * Set the number of favorites
     *
     * @param int $favorites
     * @return self
     */
    public function favorites( int $favorites ) : self
    {
        $this->favorites = $favorites;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $statistics = $this->createElement( 'media:statistics' );

        if ( $this->views ) {
            $statistics->setAttribute( 'views', $this->views );
        }

        if ( $this->favorites ) {
            $statistics->setAttribute( 'favorites', $this->favorites );
        }

        return $statistics;
    }

}