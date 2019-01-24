<?php

namespace Lukaswhite\FeedWriter\Entities\Spotify;
use Lukaswhite\FeedWriter\Entities\Podlove\Chapter;

/**
 * Class Item
 *
 * @package Lukaswhite\FeedWriter\Entities\Spotify
 */
class Item extends \Lukaswhite\FeedWriter\Entities\Itunes\Item
{
    /**
     * The start of the window during which an episode is valid
     *
     * @var \DateTime
     */
    protected $validFrom;

    /**
     * The end of the window during which an episode is valid
     *
     * @var \DateTime
     */
    protected $validTo;

    /**
     * The chapters, or segments of interest
     *
     * @var array
     */
    protected $chapters = [ ];

    /**
     * Specify a time window during which this episode is valid
     *
     * @param \DateTime $from
     * @param \DateTime $to
     * @return self
     */
    public function valid( \DateTime $from, \DateTime $to )
    {
        $this->validFrom = $from;
        $this->validTo = $to;
        return $this;
    }

    /**
     * Add a chapter
     *
     * @param string $start
     * @param string $title
     * @return Chapter
     */
    public function addChapter( ) : Chapter
    {
        $chapter = new Chapter( $this->feed );
        $this->chapters[ ] = $chapter;
        return $chapter;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $item = parent::element( );

        if ( $this->validFrom && $this->validTo ) {
            $item->appendChild( $this->createElement(
                'dcterms:valid',
                '',
                [
                    'start' =>  $this->validFrom->format( DATE_ISO8601 ),
                    'end' =>  $this->validTo->format( DATE_ISO8601 ),
                ]
            ) );
            $this->feed->registerNamespace( 'dcterms', 'https://purl.org/dc/terms/' );
        }

        if ( count( $this->chapters ) ) {
            $chapters = $this->createElement( 'psc:chapters' );
            foreach( $this->chapters as $chapter ) {
                $chapters->appendChild( $chapter->element( ) );
            }
            $item->appendChild( $chapters );
            $this->feed->registerNamespace( 'psc', 'https://podlove.org/simple-chapters/' );
        }

        return $item;
    }
}