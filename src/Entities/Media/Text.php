<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Exceptions\InvalidExpressionException;
use Lukaswhite\FeedWriter\Exceptions\InvalidMediumException;
use Lukaswhite\FeedWriter\Traits\HasDimensions;
use Lukaswhite\FeedWriter\Traits\HasUrl;

/**
 * Class Text
 *
 * @package Lukaswhite\FeedWriter\Entities\Media
 */
class Text extends Entity
{
    /**
     * The text content
     *
     * @var string
     */
    protected $content;

    /**
     * The type of content (plain / html)
     *
     * @var string
     */
    protected $contentType;

    /**
     * The language
     *
     * @var string
     */
    protected $language;

    /**
     * The start time
     *
     * @var string
     */
    protected $start;

    /**
     * The end time
     *
     * @var string
     */
    protected $end;

    /**
     * Convert this entity into an XML element
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $text = $this->createElement(
            'media:text',
            $this->content,
            [ ],
            ( $this->contentType == 'html' )
        );

        if ( $this->contentType ) {
            $text->setAttribute( 'type', $this->contentType );
        }

        if ( $this->language ) {
            $text->setAttribute( 'lang', $this->language );
        }

        if ( $this->start ) {
            $text->setAttribute( 'start', $this->start );
        }

        if ( $this->end ) {
            $text->setAttribute( 'end', $this->end );
        }

        return $text;

    }

    /**
     * Set the content
     *
     * @param string $content
     * @param string|null $type
     * @return $this
     */
    public function content( string $content, string $type = null ) : self
    {
        $this->content = $content;
        $this->contentType = $type;
        return $this;
    }

    /**
     * @param string $language
     * @return Text
     */
    public function language( string $language ) : self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param string $start
     * @return Text
     */
    public function start( string $start ) : self
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @param string $end
     * @return Text
     */
    public function end( string $end ) : self
    {
        $this->end = $end;
        return $this;
    }



}