<?php

namespace Lukaswhite\FeedWriter\Entities\Rss;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Cloud
 *
 * The cloud element indicates that updates to the feed can be monitored using a web service
 * that implements the RssCloud application programming interface (OPTIONAL).
 *
 * @package Lukaswhite\FeedWriter\Entities\Rss
 */
class Cloud extends Entity
{
    /**
     * The host name or IP address of the web service that monitors updates to the feed.
     *
     * @var string
     */
    protected $domain;

    /**
     * The web service's path
     *
     * @var string
     */
    protected $path;

    /**
     * The web service's TCP port
     *
     * @var int
     */
    protected $port;

    /**
     * The protocol; i.e. XML-RPC or soap
     *
     * @var string
     */
    protected $protocol;

    /**
     * The remote procedure to call when requesting notification of updates.
     *
     * @var string
     */
    protected $registerProcedure;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $cloud = $this->createElement( 'cloud' );

        if ( $this->domain ) {
            $cloud->setAttribute( 'domain', $this->domain );
        }

        if ( $this->path ) {
            $cloud->setAttribute( 'path', $this->path );
        }

        if ( $this->port ) {
            $cloud->setAttribute( 'port', $this->port );
        }

        if ( $this->protocol ) {
            $cloud->setAttribute( 'protocol', $this->protocol );
        }

        if ( $this->registerProcedure ) {
            $cloud->setAttribute( 'registerProcedure', $this->registerProcedure );
        }

        return $cloud;
    }

    /**
     * @param string $domain
     * @return Category
     */
    public function domain( $domain ) : self
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @param string $path
     * @return Cloud
     */
    public function path($path) : self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param int $port
     * @return Cloud
     */
    public function port($port) : self
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @param string $protocol
     * @return Cloud
     */
    public function protocol($protocol) : self
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @param string $registerProcedure
     * @return Cloud
     */
    public function registerProcedure($registerProcedure) : self
    {
        $this->registerProcedure = $registerProcedure;
        return $this;
    }

}