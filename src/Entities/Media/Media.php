<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Exceptions\InvalidExpressionException;
use Lukaswhite\FeedWriter\Exceptions\InvalidMediumException;
use Lukaswhite\FeedWriter\Traits\HasDimensions;
use Lukaswhite\FeedWriter\Traits\HasUrl;

/**
 * Class Media
 *
 * @package Lukaswhite\FeedWriter\Helpers
 */
class Media extends Entity
{
    use HasUrl,
        HasDimensions;

    /**
     * Class constants representing the available mediums
     */
    const IMAGE             =   'image';
    const VIDEO             =   'video';
    const AUDIO             =   'audio';
    const DOCUMENT          =   'document';
    const EXECUTABLE        =   'executable';

    /**
     * Class constants representing the available expressions
     */
    const SAMPLE            =   'sample';
    const FULL              =   'full';
    const NONSTOP           =   'nonstop';

    /**
     * The (Mime) type
     * @var string
     */
    protected $type;

    /**
     * The medium; e.g. image, video
     *
     * @var string
     */
    protected $medium;

    /**
     * Indicates whether you’re linking to a short sample of a longer video (“sample”),
     * or if you’re linking to the full thing (“full”), or if you’re linking to a live stream (“nonstop”).
     *
     * @var string
     */
    protected $expression;

    /**
     * Whether this is the default media item
     *
     * @var bool
     */
    protected $isDefault;

    /**
     * The file size
     *
     * @var int
     */
    protected $fileSize;

    /**
     * The duration, in seconds
     *
     * @var int
     */
    protected $duration;

    /**
     * The bitrate
     *
     * @var int
     */
    protected $bitrate;

    /**
     * The framerate
     *
     * @var int
     */
    protected $framerate;

    /**
     * The title of the item
     *
     * @var string
     */
    protected $title;

    /**
     * A description of the item
     *
     * @var string
     */
    protected $description;

    /**
     * The thumbnail, if applicable
     *
     * @var Thumbnail
     */
    protected $thumbnail;

    /**
     * The player; e.g. a page that has an embedded video player for this media item
     *
     * @var string
     */
    protected $player;

    /**
     * Convert this entity into an XML element
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $media = $this->feed->getDocument( )->createElement( 'media:content' );

        $media->setAttribute( 'url', $this->url );

        if ( $this->type ) {
            $media->setAttribute( 'type', $this->type );
        }

        if ( $this->medium ) {
            $media->setAttribute( 'medium', $this->medium );
        }

        if ( $this->fileSize ) {
            $media->setAttribute( 'fileSize', $this->fileSize );
        }

        $this->addDimensionsToElement( $media );

        if ( $this->duration ) {
            $media->setAttribute( 'duration', $this->duration );
        }

        if ( $this->bitrate ) {
            $media->setAttribute( 'bitrate', $this->bitrate );
        }

        if ( $this->framerate ) {
            $media->setAttribute( 'framerate', $this->framerate );
        }

        if ( $this->expression ) {
            $media->setAttribute( 'expression', $this->expression );
        }

        if ( $this->isDefault ) {
            $media->setAttribute( 'isDefault', 'true' );
        }

        if ( $this->title ) {
            $title = $this->createElement( 'media:title', $this->title );
            $media->appendChild( $title );
        }

        if ( $this->description ) {
            $description = $this->createElement( 'media:description', $this->description );
            $media->appendChild( $description );
        }

        if ( $this->thumbnail ) {
            $media->appendChild( $this->thumbnail->element( ) );
        }

        if ( $this->player ) {
            $player = $this->createElement( 'media:player', null );
            $player->setAttribute( 'url', $this->player );
            $media->appendChild( $player );
        }

        return $media;
    }

    /**
     * Set the (MIME) type
     *
     * @param string $type
     * @return Media
     */
    public function type( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set the medium; e.g. image, video, audio
     *
     * @param string $medium
     * @return Media
     * @throws InvalidMediumException
     */
    public function medium( string $medium ) : self
    {
        if ( ! in_array(
            $medium,
            [
                self::IMAGE,
                self::VIDEO,
                self::AUDIO,
                self::DOCUMENT,
                self::EXECUTABLE,
            ]
        ) ) {
            throw new InvalidMediumException( 'Invalid medium' );
        }
        $this->medium = $medium;
        return $this;
    }

    /**
     * Set the expression; e.g. whether it's a sample, a full video, or non-stop
     *
     * @param string $expression
     * @return Media
     * @throws InvalidExpressionException
     */
    public function expression( string $expression ) : self
    {
        if ( ! in_array(
            $expression,
            [
                self::SAMPLE,
                self::FULL,
                self::NONSTOP,
            ]
        ) ) {
            throw new InvalidExpressionException( 'Invalid expression' );
        }
        $this->expression = $expression;
        return $this;
    }

    /**
     * Set a flag to indicate whether this is the default media item, where there are
     * multiple items.
     *
     * @param bool $isDefault
     * @return Media
     */
    public function isDefault( bool $isDefault = true ) : self
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    /**
     * Set the file size, in bytes
     *
     * @param int $fileSize
     * @return Media
     */
    public function fileSize( int $fileSize ) : self
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * Set the duration, in seconds
     *
     * @param int $duration
     * @return Media
     */
    public function duration( int $duration ) : self
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * Set the bit-rate
     *
     * @param int $bitrate
     * @return Media
     */
    public function bitrate( int $bitrate ) : self
    {
        $this->bitrate = $bitrate;
        return $this;
    }

    /**
     * Set the frame rate
     *
     * @param int $framerate
     * @return Media
     */
    public function framerate( int $framerate ) : self
    {
        $this->framerate = $framerate;
        return $this;
    }

    /**
     * Set the media's title
     *
     * @param string $title
     * @return Media
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set a description of the media
     *
     * @param string $description
     * @return Media
     */
    public function description( string $description ) : self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the media's thumbnail
     *
     * @param Thumbnail $thumbnail
     * @return Media
     */
    public function thumbnail( Thumbnail $thumbnail ) : self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * Set the player
     *
     * @param string $player
     * @return Media
     */
    public function player( string $player ) : self
    {
        $this->player = $player;
        return $this;
    }


}