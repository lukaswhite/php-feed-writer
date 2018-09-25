<?php

namespace Lukaswhite\FeedWriter\Traits\DublinCore;

/**
 * Class SupportsDublinCore
 *
 * Dublin Core support for feeds.
 *
 * @package Lukaswhite\FeedWriter\Traits\DublinCore
 *
 * @see https://feedforall.com/macdocs/html/RSSReferenceDC.html
 */
trait SupportsDublinCore
{
    /**
     * The name of the person(s), company, organization, or service responsible for creating
     * the content of the information in the feed.
     *
     * @var string
     */
    protected $dcCreator;

    /**
     * The name of the person(s), company, organization, or service responsible for making
     * contributions the information in the feed.
     *
     * @var string
     */
    protected $dcContributor;

    /**
     * The extent or scope of the content of the resource. Coverage will typically include
     * spatial location (a place name or geographic coordinates), temporal period (a period label,
     * date, or date range) or jurisdiction (such as a named administrative entity).
     *
     * @var string
     */
    protected $dcCoverage;

    /**
     * The date of the content or the date that the content was made available as an RSS Feed.
     *
     * (ISO 8601)
     *
     * @var \DateTime
     */
    protected $dcDate;

    /**
     * The explaination including details of the content of the resource. This may include
     * an abstract, table of contents, etc.
     *
     * @var string
     */
    protected $dcDescription;

    /**
     * The media-type or dimensions of the resource. Example of dimensions can include size and duration.
     * Recommended best practice is to select a value from a controlled vocablulary.
     *
     * @var string
     */
    protected $dcFormat;

    /**
     * A number, code, URL, or other unique (unambiguous) reference to the resource within a given content.
     *
     * @var mixed
     */
    protected $dcIdentifier;

    /**
     * The language in which the feed is written. This value is usually identified by a
     * two letter Language Code.
     *
     * @var string
     */
    protected $dcLanguage;

    /**
     * The name of the person(s), company, organization, or service responsible for making
     * the information in the feed available in RSS format.
     *
     * @var string
     */
    protected $dcPublisher;

    /**
     * A reference to a related source.
     *
     * @var string
     */
    protected $dcRelation;

    /**
     * Information about the rights held in and over the resource, commonly referred to as
     * copy rights or property rights.
     *
     * @var string
     */
    protected $dcRights;

    /**
     * The Reference to a resource from which the present source is from using a formal identification
     * system. Example formal identification systems include the Uniform Resource Identifier (URI)
     * (including the Uniform Resource Locator (URL), the Digital Object Identifier (DOI)
     * and the International Standard Book Number (ISBN).
     *
     * @var string
     */
    protected $dcSource;

    /**
     * The words or expressions that describe a topic of the content of the resource.
     *
     * @var string
     */
    protected $dcSubject;

    /**
     * The name (title) for the feed, item, or image content.
     *
     * @var string
     */
    protected $dcTitle;

    /**
     * Terms describing general classifications or categories, or genres for the content.
     * Recommended best practice is to select a value from a controlled vocabulary.
     * A working draft list of Dublin Core Types can be found here:
     * http://dublincore.org/documents/dcmi-type-vocabulary/
     *
     * @var string
     */
    protected $dcType;

    /**
     * Set the name of the person(s), company, organization, or service responsible for creating
     * the content of the information in the feed.
     *
     * @param string $value
     * @return self
     */
    public function dcCreator( string $value ) : self
    {
        $this->dcCreator = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the name of the person(s), company, organization, or service responsible for making
     * contributions the information in the feed.
     *
     * @param string $value
     * @return self
     */
    public function dcContributor( string $value ) : self
    {
        $this->dcContributor = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the extent or scope of the content of the resource. Coverage will typically include
     * spatial location (a place name or geographic coordinates), temporal period (a period label,
     * date, or date range) or jurisdiction (such as a named administrative entity).
     *
     * @param string $value
     * @return self
     */
    public function dcCoverage( string $value ) : self
    {
        $this->dcCoverage = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the date of the content or the date that the content was made available as an RSS Feed.
     *
     * (ISO 8601)
     *
     * @param \DateTime $value
     * @return self
     */
    public function dcDate( \DateTime $value ) : self
    {
        $this->dcDate = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the explaination including details of the content of the resource. This may include
     * an abstract, table of contents, etc.
     *
     * @param string $value
     * @return self
     */
    public function dcDescription( string $value ) : self
    {
        $this->dcDescription = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the media-type or dimensions of the resource. Example of dimensions can include size and duration.
     * Recommended best practice is to select a value from a controlled vocablulary.
     *
     * @param string $value
     * @return self
     */
    public function dcFormat( string $value ) : self
    {
        $this->dcFormat = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set a number, code, URL, or other unique (unambiguous) reference to the resource within a given content.
     *
     * @param string $value
     * @return self
     */
    public function dcIdentifier( string $value ) : self
    {
        $this->dcIdentifier = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the language in which the feed is written. This value is usually identified by a
     * two letter Language Code.
     *
     * @param string $value
     * @return self
     */
    public function dcLanguage( string $value ) : self
    {
        $this->dcLanguage = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the name of the person(s), company, organization, or service responsible for making
     * the information in the feed available in RSS format.
     *
     * @param string $value
     * @return self
     */
    public function dcPublisher( string $value ) : self
    {
        $this->dcPublisher = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set a reference to a related source.
     *
     * @param string $value
     * @return self
     */
    public function dcRelation( string $value ) : self
    {
        $this->dcRelation = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set Information about the rights held in and over the resource, commonly referred to as
     * copy rights or property rights.
     *
     * @param string $value
     * @return self
     */
    public function dcRights( string $value ) : self
    {
        $this->dcRights = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the Reference to a resource from which the present source is from using a formal identification
     * system. Example formal identification systems include the Uniform Resource Identifier (URI)
     * (including the Uniform Resource Locator (URL), the Digital Object Identifier (DOI)
     * and the International Standard Book Number (ISBN).
     *
     * @param string $value
     * @return self
     */
    public function dcSource( string $value ) : self
    {
        $this->dcSource = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the words or expressions that describe a topic of the content of the resource.
     *
     * @param string $value
     * @return self
     */
    public function dcSubject( string $value ) : self
    {
        $this->dcSubject = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set the name (title) for the feed, item, or image content.
     *
     * @param string $value
     * @return self
     */
    public function dcTitle( string $value ) : self
    {
        $this->dcTitle = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Set terms describing general classifications or categories, or genres for the content.
     * Recommended best practice is to select a value from a controlled vocabulary.
     * A working draft list of Dublin Core Types can be found here:
     * http://dublincore.org/documents/dcmi-type-vocabulary/
     *
     * @param string $value
     * @return self
     */
    public function dcType( string $value ) : self
    {
        $this->dcType = $value;
        $this->ensureDublinCoreNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Add the Dublin Core tags to the specified element
     *
     * @param \DOMElement $el
     */
    protected function addDublinCoreTags( \DOMElement $el )
    {
        $this->feed->registerDublinCoreNamespace( );
        if ( $this->dcCreator ) {
            $el->appendChild( $this->createElement( 'dc:creator', $this->dcCreator ) );
        }
        if ( $this->dcContributor ) {
            $el->appendChild( $this->createElement( 'dc:contributor', $this->dcContributor ) );
        }
        if ( $this->dcCoverage ) {
            $el->appendChild( $this->createElement( 'dc:coverage', $this->dcCoverage ) );
        }
        if ( $this->dcDate ) {
            $el->appendChild( $this->createElement(
                'dc:date',
                $this->dcDate->format( DATE_ISO8601 )
            ) );
        }
        if ( $this->dcDescription ) {
            $el->appendChild( $this->createElement('dc:description', $this->dcDescription ) );
        }
        if ( $this->dcFormat ) {
            $el->appendChild( $this->createElement('dc:format', $this->dcFormat ) );
        }
        if ( $this->dcIdentifier ) {
            $el->appendChild( $this->createElement('dc:identifier', $this->dcIdentifier ) );
        }
        if ( $this->dcLanguage ) {
            $el->appendChild( $this->createElement('dc:language', $this->dcLanguage ) );
        }
        if ( $this->dcPublisher ) {
            $el->appendChild( $this->createElement('dc:publisher', $this->dcPublisher ) );
        }
        if ( $this->dcRelation ) {
            $el->appendChild( $this->createElement('dc:relation', $this->dcRelation ) );
        }
        if ( $this->dcRights ) {
            $el->appendChild( $this->createElement('dc:rights', $this->dcRights ) );
        }
        if ( $this->dcSource ) {
            $el->appendChild( $this->createElement('dc:source', $this->dcSource ) );
        }
        if ( $this->dcSubject ) {
            $el->appendChild( $this->createElement('dc:subject', $this->dcSubject ) );
        }
        if ( $this->dcTitle ) {
            $el->appendChild( $this->createElement('dc:title', $this->dcTitle ) );
        }
        if ( $this->dcType ) {
            $el->appendChild( $this->createElement('dc:type', $this->dcType ) );
        }
    }

    /**
     * Ensure that the Dublin Core namespace is registered. If it isn't, it will do so
     * automatically.
     *
     * @return $this
     */
    protected function ensureDublinCoreNamespaceIsRegistered( ) : self
    {
        if ( ! $this->feed->isNamespaceRegistered( 'dc' ) ) {
            $this->feed->registerDublinCoreNamespace( );
        }
        return $this;
    }

}