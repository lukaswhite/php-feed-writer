<?php

namespace Lukaswhite\FeedWriter\Entities\Spotify;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Spotify
 */
class Channel extends \Lukaswhite\FeedWriter\Entities\Itunes\AbstractChannel
{
    /**
     * A limit on the number of episodes.
     *
     * @var int
     */
    protected $limit;

    /**
     * The country of origin; i.e. the intended market/territory where the podcast is
     * relevant to the consumer
     *
     * Note that despite the name of the property being singular, it can actually have multiple
     * values - hence it being implemented as an array
     *
     * @var array
     */
    protected $countryOfOrigin;

    /**
     * Add an item
     *
     * @return Item
     */
    public function addItem( ) : Item
    {
        $item = $this->createEntity( Item::class );
        /** @var Item $item */
        $this->items[ ] = $item;
        return $item;
    }

    /**
     * Set a limit on the number of episodes to display in the client
     *
     * @param int $limit
     * @return self
     */
    public function limit( int $limit )
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set the country of origin
     *
     * @param string ...$country
     * @return self
     */
    public function countryOfOrigin( string ...$country )
    {
        $this->countryOfOrigin = $country;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $item = parent::element( );

        if ( $this->limit ) {
            $item->appendChild( $this->createElement(
                'spotify:limit',
                '',
                [
                    'recentCount'   =>  $this->limit,
                ]
            ) );
        }

        if ( $this->countryOfOrigin ) {
            $item->appendChild( $this->createElement(
                'spotify:countryOfOrigin',
                implode( ',', $this->countryOfOrigin )
            ) );
        }

        return $item;
    }

}