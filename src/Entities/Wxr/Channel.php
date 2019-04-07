<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;

use Lukaswhite\FeedWriter\Entities\Wxr\Item;
use Lukaswhite\FeedWriter\Traits\Wxr\HasCategories;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
class Channel extends \Lukaswhite\FeedWriter\Entities\Rss\Channel
{
    use HasCategories;

    /**
     * The base site URL
     *
     * @var string
     */
    protected $baseSiteUrl;

    /**
     * The base log URL
     *
     * @var string
     */
    protected $baseBlogUrl;

    /**
     * The channel's authors
     *
     * @var array
     */
    protected $authors = [ ];

    /**
     * The channel's categories
     *
     * @var array
     */
    protected $categories = [ ];

    /**
     * The channel's tags
     *
     * @var array
     */
    protected $tags = [ ];

    /**
     * The channel's terms
     *
     * @var array
     */
    protected $terms = [ ];

    /**
     * Add an item
     *
     * @return Item
     */
    public function addItem( )
    {
        $item = $this->createEntity( Post::class );
        /** @var Item $item */
        $this->items[ ] = $item;
        return $item;
    }

    /**
     * Add a tag
     *
     * @return Tag
     */
    public function addTag( ) : Tag
    {
        $tag =  $this->createEntity( Tag::class );
        /** @var Tag $tag */
        $this->tags[ ] = $tag;
        return $tag;
    }

    /**
     * Add a post.
     *
     * Note that posts are just items, but this method is here to keep some
     * consistency between RSS terminology (items) and Wordpress terminology (posts).
     *
     * @return \Lukaswhite\FeedWriter\Entities\Wxr\Item
     */
    public function addPost( ) : Post
    {
        return $this->addItem( );
    }

    /**
     * Add an author
     *
     * @return Author
     */
    public function addAuthor( )
    {
        $author = $this->createEntity( Author::class );
        /** @var Author $author */
        $this->authors[ ] = $author;
        return $author;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( )  : \DOMElement
    {
        $channel = parent::element( );

        $channel->appendChild(
            $this->createElement( 'wp:wxr_version', $this->feed->getWxrVersion( ) )
        );

        if ( $this->baseSiteUrl ) {
            $channel->appendChild(
                $this->createElement('wp:base_site_url', $this->baseSiteUrl )
            );
        }

        if ( $this->baseBlogUrl ) {
            $channel->appendChild(
                $this->createElement('wp:base_blog_url', $this->baseBlogUrl )
            );
        }

        if ( count( $this->authors ) ) {
            foreach( $this->authors as $author ) {
                $channel->appendChild( $author->element( ) );
            }
        }

        if ( count( $this->tags ) ) {
            foreach( $this->tags as $tag ) {
                $channel->appendChild( $tag->element( ) );
            }
        }

        // Now add the items
        if ( count( $this->items ) ) {
            foreach( $this->items as $item ) {
                //$channel->appendChild( $item->element( ) );
            }
        }

        return $channel;

    }

    /**
     * Set the channel's base site URL
     *
     * @param string $baseSiteUrl
     * @return self
     */
    public function baseSiteUrl( string $baseSiteUrl ) : self
    {
        $this->baseSiteUrl = $baseSiteUrl;
        return $this;
    }

    /**
     * Set the channel's base blog URL
     *
     * @param string $baseBlogUrl
     * @return self
     */
    public function baseBlogUrl( string $baseBlogUrl ) : self
    {
        $this->baseBlogUrl = $baseBlogUrl;
        return $this;
    }
}