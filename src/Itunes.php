<?php

namespace Lukaswhite\FeedWriter;

use Lukaswhite\FeedWriter\Entities\Itunes\Channel;

/**
 * Class Itunes
 *
 * @see https://github.com/simplepie/simplepie-ng/wiki/Spec:-iTunes-Podcast-RSS
 *
 * @package Lukaswhite\FeedWriter
 */
class Itunes extends RSS2
{
    /**
     * The type of feed.
     *
     * @var string
     */
    protected $feedType = 'iTunes';

    /**
     * Feed constructor.
     *
     * @param string $encoding
     */
    public function __construct( string $encoding = 'UTF-8' )
    {
        parent::__construct( $encoding );
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