<?php

namespace Lukaswhite\FeedWriter;

use Lukaswhite\FeedWriter\Entities\Wxr\Channel;

/**
 * Class WXR
 *
 * @package Lukaswhite\FeedWriter
 */
class WXR extends RSS2
{
    /**
     * The WXR version
     *
     * @var string
     */
    protected $wxrVersion = '1.0';

    /**
     * Feed constructor.
     */
    public function __construct( $encoding = 'UTF-8' )
    {
        parent::__construct( $encoding );

        $this->registerDublinCoreNamespace( );

        $this->registerNamespace(
            'wfw',
            'http://wellformedweb.org/CommentAPI/'
        );

        $this->registerNamespace(
            'excerpt',
            sprintf( 'http://wordpress.org/export/%s/excerpt/', $this->wxrVersion )
        );

        $this->registerNamespace(
            'wp',
            sprintf( 'http://wordpress.org/export/%s/', $this->wxrVersion )
        );
    }

    /**
     * Add a channel to the feed
     *
     * @return Channel
     */
    public function addChannel( )
    {
        $channel = new Channel( $this );
        $this->channels[ ] = $channel;
        return $channel;
    }

    /**
     * Set the Wxr version
     *
     * This isn't required if it's 1.0
     *
     * @param string $wxrVersion
     * @return self
     */
    public function setWxrVersion( string $wxrVersion ) : self
    {
        $this->wxrVersion = $wxrVersion;
        return $this;
    }

    /**
     * Get the Wxr version
     *
     * @return string
     */
    public function getWxrVersion( ) : string
    {
        return $this->wxrVersion;
    }

    /**
     * Build the feed
     *
     * @return \DOMDocument
     */
    public function build( ) : \DOMDocument
    {
        // Clear the document, otherwise it'll get rebuilt every time
        // you call toString( ) etc.
        $this->clear( );

        // If required, add the XSL stylesheet reference
        $this->addXslStylesheet( );

        $rss = $this->doc->createElement( 'rss' );
        $rss->setAttribute('version', '2.0');

        $this->addNamespaces( $rss );

        if ( count( $this->channels ) ) {
            foreach( $this->channels as $channel ) {
                /** @var Channel $channel */
                $rss->appendChild( $channel->element( $this->doc ) );
            }
        }

        $this->doc->appendChild( $rss );

        $this->built = true;

        return $this->doc;
    }

}