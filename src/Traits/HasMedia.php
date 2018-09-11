<?php

namespace Lukaswhite\FeedWriter\Traits;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\Media\Media;
use Lukaswhite\FeedWriter\Feed;

/**
 * Trait HasTitleAndDescription
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasMedia
{
    /**
     * The media items
     *
     * @var array
     */
    protected $media = [ ];

    /**
     * Create a media item
     *
     * @return Media
     */
    public function addMedia( ) : Media
    {
        $media = new Media( $this->feed );
        $this->media[ ] = $media;

        // Ensure that the appropriate namespace is set; if it doesn't, then do it
        // automatically
        /** @var Entity $this */
        if ( ! $this->feed->isNamespaceRegistered( 'media' ) ) {
            $this->feed->registerMediaNamespace( );
        }

        return $media;
    }

    /**
     * Add the media elements
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addMediaElements( \DOMElement $el ) : void
    {
        if ( count( $this->media ) ) {
            foreach ( $this->media as $media ) {
                /** @var Media $media */
                $el->appendChild( $media->element( $this->feed->getDocument( ) ) );
            }
        }
    }


}