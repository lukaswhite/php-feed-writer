<?php

namespace Lukaswhite\FeedWriter\Entities\Rawvoice;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Subscribe
 *
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice
 */
class Subscribe extends Entity
{
    const FEED = 'feed';
    const ITUNES = 'itunes';
    const GOOGLEPLAY = 'googleplay';
    const BLUBRRY = 'blubrry';
    const HTML = 'html';
    const STITCHER = 'stitcher';
    const TUNEIN = 'tunein';

    /**
     * The links
     *
     * @var array
     */
    protected $links = [];

    /**
     * Add a link
     *
     * @param string $type
     * @param string $url
     * @return $this
     */
    public function link(string $url, string $type): self
    {
        $this->links[$type] = $url;
        return $this;
    }

    /**
     * Set the URL of the podcast feed
     *
     * @param string $url
     * @return $this
     */
    public function feed(string $url): self
    {
       return $this->link($url, self::FEED);
    }

    /**
     * Set the iTunes URL
     *
     * @param string $url
     * @return $this
     */
    public function iTunes(string $url): self
    {
        return $this->link($url, self::ITUNES);
    }

    /**
     * Set the Googleplay URL
     *
     * @param string $url
     * @return $this
     */
    public function googleplay(string $url): self
    {
        return $this->link($url, self::GOOGLEPLAY);
    }

    /**
     * Set the Blubrry URL
     *
     * @param string $url
     * @return $this
     */
    public function blubrry(string $url): self
    {
        return $this->link($url, self::BLUBRRY);
    }

    /**
     * Set the HTML link
     *
     * @param string $url
     * @return $this
     */
    public function html(string $url): self
    {
        return $this->link($url, self::HTML);
    }

    /**
     * Set the Stitcher link
     *
     * @param string $url
     * @return $this
     */
    public function stitcher(string $url): self
    {
        return $this->link($url, self::STITCHER);
    }

    /**
     * Set the TuneIn
     *
     * @param string $url
     * @return $this
     */
    public function tuneIn(string $url): self
    {
        return $this->link($url, self::TUNEIN);
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $el = $this->feed->getDocument( )->createElement( 'rawvoice:subscribe' );
        foreach ( $this->links as $type => $url ) {
            $el->setAttribute($type, $url);
        }
        return $el;
    }

}