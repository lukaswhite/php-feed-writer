<?php

namespace Lukaswhite\FeedWriter;
use Lukaswhite\FeedWriter\Entities\Channel;

/**
 * Class Feed
 *
 * @package Lukaswhite\FeedWriter
 */
abstract class Feed
{
    /**
     * The feed type; e.g. RSS1.0, RSS2.0, Atom
     *
     * @var string
     */
    protected $feedType;

    /**
     * The DOM Document
     *
     * @var \DOMDocument
     */
    protected $doc;

    /**
     * The type
     *
     * @var string
     */
    protected $type;

    /**
     * The namespaces
     *
     * @var array
     */
    protected $namespaces = [ ];

    /**
     * The XSL stylesheet, if provided
     *
     * @var array
     */
    protected $xslStylesheet;

    /**
     * Feed constructor.
     */
    public function __construct( $encoding = 'UTF-8' )
    {
        $this->doc = new \DOMDocument( '1.0', $encoding );
    }

    /**
     * Register a namespace
     *
     * @param string $prefix
     * @param string $uri
     * @return $this
     */
    public function registerNamespace( string $prefix, string $uri ) : self
    {
        $this->namespaces[ $prefix ] = $uri;
        return $this;
    }

    /**
     * Determine whether the specified namespace has been registered
     *
     * @param string $prefix
     * @return bool
     */
    public function isNamespaceRegistered( string $prefix ) : bool
    {
        return isset( $this->namespaces[ $prefix ] );
    }

    /**
     * Un-register a namespace
     *
     * @param string $prefix
     * @return $this
     */
    public function unregisterNamespace( string $prefix ) : self
    {
        unset( $this->namespaces[ $prefix ] );
        return $this;
    }

    /**
     * Register the "content" namespace.
     *
     * @return $this
     */
    public function registerContentNamespace( ) : self
    {
        return $this->registerNamespace(
            'content',
            'http://purl.org/rss/1.0/modules/content/'
        );
    }

    /**
     * Register the "atom" namespace.
     *
     * @return $this
     */
    public function registerAtomNamespace( ) : self
    {
        return $this->registerNamespace(
            'atom',
            'http://www.w3.org/2005/Atom'
        );
    }

    /**
     * Register the "media" namespace.
     *
     * @return $this
     */
    public function registerMediaNamespace( ) : self
    {
        return $this->registerNamespace(
            'media',
            'http://search.yahoo.com/mrss/'
        );
    }

    /**
     * Register the "dc" (Dublin Core) namespace
     *
     * @return $this
     */
    public function registerDublinCoreNamespace( ) : self
    {
        return $this->registerNamespace(
            'dc',
            'http://purl.org/dc/elements/1.1/'
        );
    }

    /**
     * Register the GeoRSS namespace
     *
     * @return $this
     */
    public function registerGeoRSSNamespace( ) : self
    {
        return $this->registerNamespace(
            'georss',
            'http://www.georss.org/georss'
        );
    }

    /**
     * Register the OpenGIS namespace
     *
     * @return $this
     */
    public function registerOpenGISNamespace( ) : self
    {
        return $this->registerNamespace(
            'gml',
            'http://www.opengis.net/gml'
        );
    }

    /**
     * Get the MIME type used to deliver this feed.
     *
     * @return string
     */
    abstract public function getMimeType( ) : string;

    /**
     * Set the XSL stylesheet
     *
     * @param string $uri
     * @return $this
     */
    public function xslStylesheet( string $uri ) : self
    {
        $this->xslStylesheet = $uri;
        return $this;
    }

    /**
     * Turn on pretty-printing
     *
     * @return self
     */
    public function prettyPrint( ) : self
    {
        $this->doc->formatOutput = true;
        return $this;
    }

    /**
     * Get the XML document for this feed.
     *
     * @return \DOMDocument
     */
    public function getDocument( ) : \DOMDocument
    {
        return $this->doc;
    }

    /**
     * Optionally add the XSL stylesheet
     *
     * @return $this
     */
    protected function addXslStylesheet( ) : self
    {
        if ( $this->xslStylesheet ) {
            $this->doc->appendChild(
                $this->doc->createProcessingInstruction(
                    'xml-stylesheet',
                    sprintf(
                        'type="text/xsl" href="%s"',
                        $this->xslStylesheet
                    )
                )
            );
        }
        return $this;
    }

    /**
     * Add the namespaces
     *
     * @param \DOMElement $feed
     * @return $this
     */
    protected function addNamespaces( \DOMElement $feed ) : self
    {
        foreach ( $this->namespaces as $prefix => $uri ) {
            $feed->setAttributeNodeNS(
                new \DomAttr(
                    sprintf( 'xmlns:%s', $prefix ),
                    $uri
                )
            );
        }
        return $this;
    }

    /**
     * Clear the contents of the feed.
     *
     * @return $this
     */
    protected function clear( ) : self
    {
        if ( $this->doc->childNodes->length > 0 ) {
            $el = $this->doc->childNodes[ 0 ];
            $el->parentNode->removeChild( $el );
        }
        return $this;
    }

    /**
     * Build the feed
     *
     * @return \DOMDocument
     */
    abstract public function build( ) : \DOMDocument;

    /**
     * Get the feed as a string
     *
     * @return string
     */
    public function toString( ) : string
    {
        $this->build( );
        return $this->doc->saveXML( );
    }

    /**
     * Magic __toString( ) method
     *
     * @return string
     */
    public function __toString( ) : string
    {
        return $this->toString( );
    }
}