<?php

namespace Lukaswhite\FeedWriter\Traits;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\Media\Media;
use Lukaswhite\FeedWriter\Entities\Media\MediaGroup;

/**
 * Trait HasMediaGroups
 * 
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasMediaGroups
{
    /**
     * The media groups
     *
     * @var array
     */
    protected $mediaGroups = [ ];

    /**
     * Create a media group
     *
     * @return MediaGroup
     */
    public function addMediaGroup( ) : MediaGroup
    {
        $mediaGroup = new MediaGroup( $this->feed );
        $this->mediaGroups[ ] = $mediaGroup;

        // Ensure that the appropriate namespace is set; if it doesn't, then do it
        // automatically
        /** @var Entity $this */
        if ( ! $this->feed->isNamespaceRegistered( 'media' ) ) {
            $this->feed->registerMediaNamespace( );
        }

        return $mediaGroup;
    }

    /**
     * Add the media group elements
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addMediaGroupElements( \DOMElement $el ) : void
    {
        if ( count( $this->mediaGroups ) ) {
            foreach ( $this->mediaGroups as $mediaGroup ) {
                /** @var Media $media */
                $el->appendChild( $mediaGroup->element( $this->feed->getDocument( ) ) );
            }
        }
    }


}