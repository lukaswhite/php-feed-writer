<?php


namespace Lukaswhite\FeedWriter\Entities\Podlove;


use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Chapter
 *
 * Represents a Podlove chapter; i.e. a point in the audio file of particular interest
 * to the consumer
 *
 * @package Lukaswhite\FeedWriter\Entities\Podlove
 */
class Chapter extends Entity
{
    /**
     * The time that this chapter, or segment, starts
     *
     * @var string
     */
    protected $start;

    /**
     * The title of this chapter / segment
     *
     * @var string
     */
    protected $title;

    /**
     * An optional URL
     *
     * @var string
     */
    protected $url;

    /**
     * An optional image
     *
     * @var string
     */
    protected $image;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $chapter = $this->createElement(
            'psc:chapter',
            '',
            [
                'start' =>  $this->start,
                'title' =>  $this->title,
            ]
        );

        if ( $this->image ) {
            $chapter->setAttribute( 'image', $this->image );
        }

        if ( $this->url ) {
            $chapter->setAttribute( 'href', $this->url );
        }

        return $chapter;
    }

    /**
     * Set the start time
     *
     * @param string|int $start
     * @return Chapter
     */
    public function start( $start ) : self
    {
        if ( is_int( $start ) ) {
            $this->start = '' . $start;
        } else {
            $this->start = $start;
        }
        return $this;
    }

    /**
     * Set the title
     *
     * @param string $title
     * @return Chapter
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the (optional) URL
     *
     * @param string $url
     * @return Chapter
     */
    public function url( string $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Alias of url()
     *
     * @param string $url
     * @return Chapter
     */
    public function href( string $url ) : self
    {
        return $this->url( $url );
    }

    /**
     * Set the (optional) image
     *
     * @param string $image
     * @return Chapter
     */
    public function image( string $image ) : self
    {
        $this->image = $image;
        return $this;
    }
}