<?php

namespace Lukaswhite\FeedWriter\Traits;
use Lukaswhite\FeedWriter\Helpers\Strings;

/**
 * Trait HasDescription
 *
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasDescription
{
    /**
     * The description
     *
     * @var string
     */
    protected $description;

    /**
     * Whether to encode the description
     *
     * @var bool
     */
    protected $encodeDescription = false;

    /**
     * Set the description
     *
     * @param string $description
     * @param bool $encode
     * @return $this
     */
    public function description( string $description, $encode = null ) : self
    {
        $this->description = $description;
        if ( $encode !== null ) {
            $this->encodeDescription = $encode;
        } else {
            if ( Strings::containsHtml( $description ) ) {
                $this->encodeDescription = true;
            }
        }
        return $this;
    }

    /**
     * Add the description to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addDescriptionElement( \DOMElement $el ) : void
    {
        if ( $this->description ) {
            $el->appendChild( $this->createElement(
                'description',
                $this->description,
                [ ],
                $this->encodeDescription )
            );
        }
    }
}