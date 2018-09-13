<?php

namespace Lukaswhite\FeedWriter\Entities\Atom;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Text
 *
 * @package Lukaswhite\FeedWriter\Entities\Atom
 */
class Text extends Entity
{
    /**
     * Class constants
     */
    const PLAIN         =   'plain';
    const HTML          =   'html';
    const XHTML         =   'xhtml';

    /**
     * The tag name; e.g. title, summary, content, rights
     *
     * @var string
     */
    protected $tagName;

    /**
     * The content
     *
     * @var string
     */
    protected $content;

    /**
     * The type; e.g. text, html, xhtml
     *
     * @var string
     */
    protected $type;

    /**
     * Whether to encode the contents; i.e. wrap in a CDATA section
     *
     * @var bool
     */
    protected $encode = false;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        if ( ! $this->encode && in_array( $this->type, [ 'html', 'xhtml' ] ) ) {
            $this->encode = true;
        }
        $text = $this->createElement( $this->tagName, $this->content, [ ], $this->encode );

        if ( $this->type ) {
            $text->setAttribute( 'type', $this->type );
        }

        return $text;
    }

    /**
     * Set the tag name; e.g. title, summary, content, rights
     *
     * @param string $tagName
     * @return $this
     */
    public function tagName( string $tagName ) : self
    {
        $this->tagName = $tagName;
        return $this;
    }

    /**
     * @param string $content
     * @return Text
     */
    public function content( string $content ) : self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param string $type
     * @return Text
     */
    public function type( $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param bool $encode
     * @return Text
     */
    public function encode( bool $encode = true ) : self
    {
        $this->encode = $encode;
        return $this;
    }



}