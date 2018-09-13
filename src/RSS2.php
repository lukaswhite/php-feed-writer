<?php

namespace Lukaswhite\FeedWriter;

use Lukaswhite\FeedWriter\Entities\Rss\Channel;

/**
 * Class RSS2
 *
 * @package Lukaswhite\FeedWriter
 */
class RSS2 extends Feed
{
    /**
     * The feed type; e.g. RSS1.0, RSS2.0, Atom
     * 
     * @var string
     */
    protected $feedType = 'RSS2.0';

    /**
     * The channels that make up this feed
     *
     * @var array
     */
    protected $channels = [ ];

    /**
     * Feed constructor.
     */
    public function __construct( $encoding = 'UTF-8' )
    {
        parent::__construct( $encoding );
        $this->registerContentNamespace( );
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
     * Get the MIME type used to deliver this feed.
     *
     * @return string
     */
    public function getMimeType( ) : string
    {
        return 'application/rss+xml';
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

        //$rss->setAttributeNodeNS(new \DomAttr('xmlns:atom', 'http://www.w3.org/2005/Atom'));

        $this->doc->appendChild( $rss );

        $this->built = true;

        return $this->doc;
    }

}