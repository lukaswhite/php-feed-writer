<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

use Lukaswhite\FeedWriter\Traits\Itunes\HasAuthor;
use Lukaswhite\FeedWriter\Traits\Itunes\HasBlock;
use Lukaswhite\FeedWriter\Traits\Itunes\HasCategories;
use Lukaswhite\FeedWriter\Traits\Itunes\HasEpisodeType;
use Lukaswhite\FeedWriter\Traits\Itunes\HasExplicit;
use Lukaswhite\FeedWriter\Traits\Itunes\HasImage;
use Lukaswhite\FeedWriter\Traits\Itunes\HasSubtitle;
use Lukaswhite\FeedWriter\Traits\Itunes\HasSummary;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Itunes
 */
abstract class AbstractChannel extends \Lukaswhite\FeedWriter\Entities\Rss\Channel
{
    use HasSubtitle,
        HasSummary,
        HasAuthor,
        HasImage,
        HasExplicit,
        HasBlock,
        HasCategories,
        HasEpisodeType;

    const EPISODIC  =   'episodic';
    const SERIAL    =   'serial';

    /**
     * The owner's name
     *
     * @var string
     */
    protected $ownerName;

    /**
     * The owner's e-mail address
     *
     * @var string
     */
    protected $ownerEmail;

    /**
     * Whether this podcast is complete; i.e. you will not post any more episodes in the future.
     *
     * @var bool
     */
    protected $isComplete = false;

    /**
     * The new feed URL, to manually change where a podcast is located.
     *
     * @var string
     */
    protected $newFeedUrl;

    /**
     * The categories
     *
     * @var array
     */
    protected $categories = [ ];

    /**
     * @var string
     */
    protected $type;

    /**
     * Set the owner
     *
     * @param string $name
     * @param string $email
     * @return Channel
     */
    public function owner( string $name, $email = null ) : self
    {
        $this->ownerName = $name;
        $this->ownerEmail = $email;
        return $this;
    }

    /**
     * Indicate that this podcast is complete; i.e. you will not post any more episodes in the future.
     *
     * @param bool $complete
     * @return $this
     */
    public function isComplete( bool $complete = true ) : self
    {
        $this->isComplete = $complete;
        return $this;
    }

    /**
     * Set a new feed URL, to manually change where a podcast is located.
     *
     * @param string $url
     * @return $this
     */
    public function newFeedUrl( string $url ) : self
    {
        $this->newFeedUrl = $url;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return $this
     */
    public function episodic(): self
    {
        return $this->type(self::EPISODIC);
    }

    /**
     * @return $this
     */
    public function serial(): self
    {
        return $this->type(self::SERIAL);
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $channel = $this->createElement( 'channel' );
        $this->feed->getDocument( )->appendChild( $channel );

        $this->addTitleElement( $channel );
        $this->addDescriptionElement( $channel );

        $this->addLinkElement( $channel );

        if ( $this->language ) {
            $channel->appendChild( $this->createElement( 'language', $this->language ) );
        }

        if ( $this->copyright ) {
            $channel->appendChild( $this->createElement( 'copyright', $this->copyright ) );
        }

        if ( $this->lastBuildDate ) {
            $channel->appendChild( $this->createElement(
                'lastBuildDate',
                $this->lastBuildDate->format( DATE_RSS ) )
            );
        }

        $this->addPublishedDateElement( $channel );

        $this->addSubtitleElement( $channel );
        $this->addSummaryElement( $channel );
        $this->addAuthorElement( $channel );
        if ( $this->ownerName ) {
            $owner = $channel->appendChild( $this->createElement( 'itunes:owner' ) );
            $owner->appendChild( $this->createElement( 'itunes:name', $this->ownerName ) );
            if ( $this->ownerEmail ) {
                $owner->appendChild( $this->createElement( 'itunes:email', $this->ownerEmail ) );
            }
        }

        $this->addImageElement( $channel );

        $this->addExplicitElement( $channel );

        $this->addBlockElement( $channel );

        if ( $this->type ) {
            $channel->appendChild( $this->createElement( 'itunes:type', $this->type ) );
        }

        if ( $this->isComplete ) {
            $channel->appendChild( $this->createElement( 'itunes:complete', 'Yes' ) );
        }

        if ( $this->newFeedUrl ) {
            $channel->appendChild( $this->createElement( 'itunes:new-feed-url', $this->newFeedUrl ) );
        }

        $this->addEpisodeTypeElement( $channel );

        if ( $this->generator ) {
            $channel->appendChild( $this->createElement( 'generator', $this->generator ) );
        }

        if ( $this->ttl ) {
            $channel->appendChild( $this->createElement( 'ttl', $this->ttl ) );
        }

        // Optionally add the categories
        $this->addCategoryElements( $channel );

        // Now add the items
        if ( count( $this->items ) ) {
            foreach( $this->items as $item ) {
                $channel->appendChild( $item->element( ) );
            }
        }

        return $channel;

    }
}