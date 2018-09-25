<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Entities\General\Link;
use Lukaswhite\FeedWriter\Entities\Media\Community\Community;
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
     * The type of the title (plain or HTML)
     *
     * @var string
     */
    protected $titleType;

    /**
     * A description of the item
     *
     * @var string
     */
    protected $description;

    /**
     * The type of the description (plain or HTML)
     *
     * @var string
     */
    protected $descriptionType;

    /**
     * The status of the media
     *
     * @var Status
     */
    protected $status;

    /**
     * The license
     *
     * @var License
     */
    protected $license;

    /**
     * Keywords that describe this media
     *
     * @var array
     */
    protected $keywords = [ ];

    /**
     * The thumbnails
     *
     * @var array
     */
    protected $thumbnails = [ ];

    /**
     * The locations
     *
     * @var array
     */
    protected $locations = [ ];

    /**
     * The player; e.g. a page that has an embedded video player for this media item
     *
     * @var string
     */
    protected $player;

    /**
     * The embed
     *
     * @var Embed
     */
    protected $embed;

    /**
     * The hash of the binary media file.
     *
     * @var string
     */
    protected $hash;

    /**
     * The algorithm used to create the hash.
     *
     * @var string
     */
    protected $hashAlgorithm;

    /**
     * The categories
     *
     * @var array
     */
    protected $categories = [ ];

    /**
     * Comments on the media
     *
     * @var array
     */
    protected $comments = [ ];

    /**
     * The credits
     *
     * @var array
     */
    protected $credits = [ ];

    /**
     * The text (transcripts)
     *
     * @var array
     */
    protected $texts = [ ];

    /**
     * The restrictions
     *
     * @var array
     */
    protected $restrictions = [ ];

    /**
     * The prices
     *
     * @var array
     */
    protected $prices = [ ];

    /**
     * The scenes
     *
     * @var array
     */
    protected $scenes = [ ];

    /**
     * Back links
     *
     * @var array
     */
    protected $backLinks = [ ];

    /**
     * Optional P2P link
     *
     * @var Link
     */
    protected $peerLink;

    /**
     * The ratings
     *
     * @var array
     */
    protected $ratings = [ ];

    /**
     * The responses
     *
     * @var array
     */
    protected $responses = [ ];

    /**
     * The community-related content
     *
     * @var Community
     */
    protected $community;

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
            $title = $this->createElement(
                'media:title',
                $this->title,
                [ ],
                ( $this->titleType === 'html' )
            );
            if ( $this->titleType ) {
                $title->setAttribute( 'type', $this->titleType );
            }
            $media->appendChild( $title );
        }

        if ( $this->description ) {
            $description = $this->createElement(
                'media:description',
                $this->description,
                [ ],
                ( $this->descriptionType === 'html' )
            );
            if ( $this->descriptionType ) {
                $description->setAttribute( 'type', $this->descriptionType );
            }
            $media->appendChild( $description );
        }

        if ( $this->status ) {
            $media->appendChild( $this->status->element( ) );
        }

        if ( $this->license ) {
            $media->appendChild( $this->license->element( ) );
        }

        if ( count( $this->keywords ) ) {
            $media->appendChild(
                $this->createElement(
                    'media:keywords',
                    implode( ', ', $this->keywords )
                )
            );
        }

        if ( count( $this->thumbnails ) ) {
            foreach( $this->thumbnails as $thumbnail ) {
                $media->appendChild( $thumbnail->element( ) );
            }
        }

        if ( count( $this->locations ) ) {
            foreach( $this->locations as $location ) {
                $media->appendChild( $location->element( ) );
            }
        }

        if ( $this->player ) {
            $player = $this->createElement( 'media:player', null );
            $player->setAttribute( 'url', $this->player );
            $media->appendChild( $player );
        }

        if ( $this->embed ) {
            $media->appendChild( $this->embed->element( ) );
        }

        if ( $this->hash ) {
            $hash = $this->createElement( 'media:hash', $this->hash );
            if ( $this->hashAlgorithm ) {
                $hash->setAttribute( 'algo', $this->hashAlgorithm );
            }
            $media->appendChild( $hash );
        }

        if ( count( $this->comments ) ) {
            $comments = $this->createElement( 'media:comments' );
            foreach( $this->comments as $comment ) {
                $comments->appendChild( $this->createElement( 'media:comment', $comment ) );
            }
            $media->appendChild( $comments );
        }

        if ( count( $this->categories ) ) {
            foreach( $this->categories as $category ) {
                $media->appendChild( $category->element( ) );
            }
        }

        if ( $this->copyright ) {
            $media->appendChild( $this->copyright->element( ) );
        }

        if ( count( $this->credits ) ) {
            foreach( $this->credits as $credit ) {
                /** @var Credit $credit */
                $media->appendChild( $credit->element( ) );
            }
        }

        if ( count( $this->texts ) ) {
            foreach( $this->texts as $text ) {
                /** @var Text $text */
                $media->appendChild( $text->element( ) );
            }
        }

        if ( count( $this->restrictions ) ) {
            foreach( $this->restrictions as $restriction ) {
                /** @var Restriction $restriction */
                $media->appendChild( $restriction->element( ) );
            }
        }

        if ( count( $this->prices ) ) {
            foreach( $this->prices as $price ) {
                /** @var Price $price */
                $media->appendChild( $price->element( ) );
            }
        }

        if ( count( $this->scenes ) ) {
            $scenes = $media->appendChild( $this->createElement( 'media:scenes' ) );
            foreach( $this->scenes as $scene ) {
                /** @var Scene $scene */
                $scenes->appendChild( $scene->element( ) );
            }
        }

        if ( count( $this->backLinks ) ) {
            $backLinks = $media->appendChild( $this->createElement( 'media:backLinks' ) );
            foreach( $this->backLinks as $backLink ) {
                $backLinks->appendChild( $this->createElement( 'media:backLink', $backLink ) );
            }
        }

        if ( $this->peerLink ) {
            $media->appendChild( $this->peerLink->element( ) );
        }

        if ( count( $this->ratings ) ) {
            foreach( $this->ratings as $rating ) {
                /** @var Rating $rating */
                $media->appendChild( $rating->element( ) );
            }
        }

        if ( count( $this->responses ) ) {
            foreach( $this->responses as $response ) {
                $media->appendChild( $this->createElement( 'media:response', $response ) );
            }
        }

        if ( $this->community ) {
            $media->appendChild( $this->community->element( ) );
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
     * @param string $type
     * @return Media
     */
    public function title( string $title, $type = null ) : self
    {
        $this->title        =   $title;
        $this->titleType    =   $type;
        return $this;
    }

    /**
     * Set a description of the media
     *
     * @param string $description
     * @param string $type
     * @return Media
     */
    public function description( string $description, $type = null ) : self
    {
        $this->description = $description;
        $this->descriptionType = $type;
        return $this;
    }

    /**
     * Set the status of the media
     *
     * @param string $state
     * @param string $reason
     * @return self
     */
    public function status( string $state, string $reason )
    {
        $this->status = ( new Status( $this->feed ) )
            ->state( $state )
            ->reason( $reason );
        return $this;
    }

    /**
     * Specify the license
     *
     * @param string $name
     * @param string $url
     * @param string $type
     * @return self
     */
    public function license( string $name, string $url, string $type = 'text/html' )
    {
        $this->license = ( new License( $this->feed ) )
            ->name( $name )
            ->type( $type )
            ->url( $url );
        return $this;
    }

    /**
     * Set the keywords
     *
     * @param string ...$keywords
     * @return Media
     */
    public function keywords( string ...$keywords ) : self
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Add a thumbnail
     *
     * @return Thumbnail
     */
    public function addThumbnail( ) : Thumbnail
    {
        $thumbnail = new Thumbnail( $this->feed );
        $this->thumbnails[ ] = $thumbnail;
        return $thumbnail;
    }

    /**
     * Add a location
     *
     * @return Location
     */
    public function addLocation( ) : Location
    {
        $location = new Location( $this->feed );
        $this->locations[ ] = $location;
        $this->feed->registerGeoRSSNamespace( );
        $this->feed->registerOpenGISNamespace( );
        return $location;
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

    /**
     * Add an embed
     *
     * @return Embed
     */
    public function addEmbed( ) : Embed
    {
        $this->embed = new Embed( $this->feed );
        return $this->embed;
    }

    /**
     * Set the hash of the binary media file
     *
     * @param string $hash
     * @param string $algorithm
     * @return $this
     */
    public function hash( $hash, $algorithm = null ) : self
    {
        $this->hash = $hash;
        $this->hashAlgorithm = $algorithm;
        return $this;
    }

    /**
     * Add one or more comments
     *
     * @param string ...$comments
     * @return Media
     */
    public function comments( string ...$comments ) : self
    {
        foreach( $comments as $comment ) {
            $this->comments[ ] = $comment;
        }
        return $this;
    }

    /**
     * Add a category
     *
     * @return Category
     */
    public function addCategory( ) : Category
    {
        $category = new Category( $this->feed );
        $this->categories[ ] = $category;
        return $category;
    }

    /**
     * Set the copyright notice
     *
     * @param string $text
     * @param string $url
     * @return self
     */
    public function copyright( string $text, ?string $url ) : self
    {
        $this->copyright = ( new Copyright( $this->feed ) )->text( $text );
        if ( $url ){
            $this->copyright->url( $url );
        }
        return $this;
    }

    /**
     * An optional copyright notice
     *
     * @var Copyright
     */
    protected $copyright;

    /**
     * Add a credit
     *
     * @return Credit
     */
    public function addCredit( ) : Credit
    {
        $credit = new Credit( $this->feed );
        $this->credits[ ] = $credit;
        return $credit;
    }

    /**
     * Add a text (transcript)
     *
     * @return Text
     */
    public function addText( ) : Text
    {
        $text = new Text( $this->feed );
        $this->texts[ ] = $text;
        return $text;
    }

    /**
     * Add a restriction
     *
     * @return Restriction
     */
    public function addRestriction( ) : Restriction
    {
        $restriction = new Restriction( $this->feed );
        $this->restrictions[ ] = $restriction;
        return $restriction;
    }

    /**
     * Add a price
     *
     * @return Price
     */
    public function addPrice( ) : Price
    {
        $price = new Price( $this->feed );
        $this->prices[ ] = $price;
        return $price;
    }

    /**
     * Add a scene
     *
     * @return Scene
     */
    public function addScene( ) : Scene
    {
        $scene = new Scene( $this->feed );
        $this->scenes[ ] = $scene;
        return $scene;
    }

    /**
     * Add a back link
     *
     * @param string $link
     * @return self
     */
    public function addBacklink( string $link ) : self
    {
        $this->backLinks[ ] = $link;
        return $this;
    }

    /**
     * Set the peer link
     *
     * @param string $url
     * @param string $type
     * @return self
     */
    public function peerLink( string $url, string $type ) : self
    {
        $this->peerLink = ( new Link( $this->feed ) )
            ->tagName( 'media:peerLink' )
            ->url( $url )
            ->type( $type );
        return $this;
    }

    /**
     * Add a rating
     *
     * @param string $value
     * @param string $scheme
     * @return self
     */
    public function addRating( string $value, $scheme = null ) : self
    {
        $rating = new Rating( $this->feed );
        $rating->value( $value );
        if ( $scheme ) {
            $rating->scheme( $scheme );
        }
        $this->ratings[ ] = $rating;
        return $this;
    }

    /**
     * Add a response
     *
     * @param string $response
     * @return self
     */
    public function addResponse( string $response ) : self
    {
        $this->responses[ ] = $response;
        return $this;
    }

    /**
     * Set multiple responses at a time
     *
     * @param string ...$responses
     * @return self
     */
    public function responses( string ...$responses ) : self
    {
        $this->responses = $responses;
        return $this;
    }

    /**
     * Add community-related content
     *
     * @return Community
     */
    public function addCommunity( ) : Community
    {
        $this->community = new Community( $this->feed );
        return $this->community;
    }

}