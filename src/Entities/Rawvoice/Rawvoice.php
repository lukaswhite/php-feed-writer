<?php

namespace Lukaswhite\FeedWriter\Entities\Rawvoice;

use Lukaswhite\FeedWriter\Feed;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;

/**
 * Class Rawvoice
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice
 */
class Rawvoice
{
    use CreatesDOMElements;

    const NAMESPACE = 'http://www.rawvoice.com/rawvoiceRssModule/';

    /**
     * @var Subscribe
     */
    protected $subscribe;

    /**
     * @var Rating
     */
    protected $rating;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $frequency;

    /**
     * @var string
     */
    protected $poster;

    /**
     * @var bool
     */
    protected $isHd = false;

    /**
     * @var string
     */
    protected $donate;

    /**
     * @var string
     */
    protected $donateValue;

    /**
     * The feed
     *
     * @var Feed
     */
    protected $feed;

    /**
     * Rawvoice constructor.
     *
     * @param Feed $feed
     */
    public function __construct( Feed $feed )
    {
        $this->feed = $feed;
    }

    /**
     * @return Subscribe
     */
    public function subscribe()
    {
        if ( ! $this->subscribe ) {
            $this->subscribe = new Subscribe($this->feed);
        }
        return $this->subscribe;
    }

    /**
     * @param string $rating
     * @return Rating
     */
    public function rating($rating)
    {
        if ( ! $this->rating ) {
            $this->rating = new Rating($this->feed);
            $this->rating->value($rating);
        }
        return $this->rating;
    }

    /**
     * @param string $location
     * @return Rawvoice
     */
    public function location(string $location): Rawvoice
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @param string $frequency
     * @return Rawvoice
     */
    public function frequency(string $frequency): Rawvoice
    {
        $this->frequency = $frequency;
        return $this;
    }

    /**
     * @param string $poster
     * @return Rawvoice
     */
    public function poster(string $poster): Rawvoice
    {
        $this->poster = $poster;
        return $this;
    }

    /**
     * @return Rawvoice
     */
    public function isHd(): Rawvoice
    {
        $this->isHd = true;
        return $this;
    }

    /**
     * @param string $donate
     * @param string $donateValue
     * @return Rawvoice
     */
    public function donate(string $donate, string $donateValue = null): Rawvoice
    {
        $this->donate = $donate;
        $this->donateValue = $donateValue;
        return $this;
    }

    /**
     * Add the GeoRSS tags to the specified element
     *
     * @param \DOMElement $el
     */
    public function addTags( \DOMElement $el )
    {
        if($this->subscribe) {
            $el->appendChild( $this->subscribe->element() );
        }
        if($this->rating) {
            $el->appendChild( $this->rating->element() );
        }
        if($this->location) {
            $el->appendChild( $this->createElement('rawvoice:location', $this->location));
        }
        if($this->frequency) {
            $el->appendChild( $this->createElement('rawvoice:frequency', $this->frequency));
        }
        if($this->poster) {
            $el->appendChild( $this->createElement('rawvoice:poster', $this->poster));
        }
        if($this->isHd) {
            $el->appendChild( $this->createElement('rawvoice:isHd', 'yes'));
        }
        if($this->donate) {
            $donate = $el->appendChild( $this->createElement('rawvoice:donate', $this->donateValue));
            $donate->setAttribute('href', $this->donate);
        }
    }


}