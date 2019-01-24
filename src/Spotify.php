<?php

namespace Lukaswhite\FeedWriter;

use Lukaswhite\FeedWriter\Entities\Spotify\Channel;

/**
 * Class Spotify
 *
 * @see https://podcasters.spotify.com/terms/Spotify_Podcast_Delivery_Specification_v1.5.pdf
 *
 * @package Lukaswhite\FeedWriter
 */
class Spotify extends RSS2
{
    /**
     * The type of feed.
     *
     * @var string
     */
    protected $feedType = 'Spotify';

    /**
     * Feed constructor.
     *
     * @param string $encoding
     */
    public function __construct( string $encoding = 'UTF-8' )
    {
        parent::__construct( $encoding );
        $this->registerNamespace( 'spotify', 'https://www.spotify.com/ns/rss' );
        $this->registerNamespace( 'itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd' );
        $this->unregisterNamespace( 'content' );
    }

    /**
     * Add a channel to the feed
     *
     * @return Channel
     */
    public function addChannel( ) : Channel
    {
        $channel = new Channel( $this );
        $this->channels[ ] = $channel;
        return $channel;
    }

}