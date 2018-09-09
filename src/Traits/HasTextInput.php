<?php

namespace Lukaswhite\FeedWriter\Traits;

use Lukaswhite\FeedWriter\Entities\Rss\TextInput;


/**
 * Trait HasTextInput
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasTextInput
{
    /**
     * The text input
     *
     * @var TextInput
     */
    protected $textInput;

    /**
     * Add a text input
     *
     * @return TextInput
     */
    public function addTextInput( ) : TextInput
    {
        $this->textInput = new TextInput( $this->feed );
        return $this->textInput;
    }

    /**
     * Add the textInput element
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addTextInputElement( \DOMElement $el ) : void
    {
        if ( $this->textInput ) {
            $el->appendChild( $this->textInput->element( ) );
        }
    }
}