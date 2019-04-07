<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;

use Lukaswhite\FeedWriter\Entities\General\Enclosure;
use Lukaswhite\FeedWriter\Traits\Wxr\HasDates;
use Lukaswhite\FeedWriter\Traits\Wxr\HasPostMeta;

/**
 * Class Item
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 * @see https://plugins.trac.wordpress.org/browser/wp-exporter/trunk/export.php
 */
class Post extends \Lukaswhite\FeedWriter\Entities\Rss\Item
{
    use     HasDates,
            HasPostMeta;

    /**
     * Class constants
     */

    /**
     * Post types
     *
     * @see https://codex.wordpress.org/Post_Type
     */
    const POST                  =   'post';
    const PAGE                  =   'page';
    const ATTACHMENT            =   'attachment';
    const REVISION              =   'revision';
    const NAV_MENU_ITEM         =   'nav_menu_item';
    const CUSTOM_CSS            =   'custom_css';
    const CUSTOMIZE_CHANGESET   =   'customize_changeset';
    const USER_REQUEST          =   'user_request';

    /**
     * Post statuses
     */
    const PUBLISHED         =   'publish';
    const DRAFT             =   'draft';
    const FUTURE            =   'future';
    const PENDING           =   'pending';
    const IS_PRIVATE        =   'private'; // format different because private is a keyword
    const TRASH             =   'trash';
    const AUTO_DRAFT        =   'auto_draft';
    const INHERIT           =   'inherit';

    /**
     * Comment statuses
     */
    const COMMENTS_OPEN     =   'open';
    const COMMENTS_CLOSED   =   'closed';

    /**
     * Ping statuses
     */
    const PINGS_OPEN        =   'open';
    const PINGS_CLOSED      =   'closed';

    /**
     * The post ID
     *
     * @var integer
     */
    protected $id;

    /**
     * The status of the post
     *
     * @var string
     *
     * @see https://codex.wordpress.org/Post_Status
     */
    protected $status;

    /**
     * The comment status
     *
     * @var string
     */
    protected $commentStatus;

    /**
     * The ping status
     *
     * @var string
     */
    protected $pingStatus;

    /**
     * The parent
     *
     * @var Post
     */
    protected $parent;

    /**
     * The menu order
     *
     * @var int
     */
    protected $menuOrder;

    /**
     * The post type
     *
     * @var string
     */
    protected $type;

    /**
     * The password
     *
     * @var string
     */
    protected $password;

    /**
     * The attachment URLs
     *
     * @var array
     */
    protected $attachmentUrls = [ ];

    /**
     * The meta
     *
     * @var array
     */
    protected $meta = [ ];

    /**
     * The terms
     *
     * @var array
     */
    protected $terms = [ ];

    /**
     * The comments
     *
     * @var array
     */
    protected $comments = [ ];

    /**
     * Add a comment
     *
     * @return Comment
     */
    public function addComment( ) : Comment
    {
        $comment = $this->createEntity( Comment::class );
        $this->comments[ ] = $comment;
        return $comment;
    }

    /**
     * Add a category
     *
     * @return Category
     */
    public function addCategory( )
    {
        $category = new Category( $this->feed );
        $this->categories[ ] = $category;
        return $category;
    }

    /**
     * Add a term
     *
     * @return Term
     */
    public function addTerm( ) : Term
    {
        $term = $this->createEntity( Term::class );
        $this->terms[ ] = $term;
        return $term;
    }

    /**
     * Set the ID
     *
     * @param int $id
     * @return $this
     */
    public function id( int $id ) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the ID
     *
     * @return int
     */
    public function getId( ) : int
    {
        return $this->id;
    }

    /**
     * Set the status of the post
     *
     * e.g. publish, draft; see the class constants
     *
     * Note: custom statuses are allowed, so you're not restricted to the
     * ones that have corresponding class constants
     *
     * @param string $status
     * @return $this
     */
    public function status( string $status ) : self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Indicate that the post is published
     *
     * It essentially just sets the status to "publish"
     *
     * @return self
     */
    public function isPublished( ) : self
    {
        return $this->status( self::PUBLISHED );
    }

    /**
     * Indicate that the post is a draft
     *
     * It essentially just sets the status to "draft"
     *
     * @return self
     */
    public function isDraft( ) : self
    {
        return $this->status( self::DRAFT );
    }

    /**
     * Indicate that the post status is "future"
     *
     * It essentially just sets the status to future
     *
     * @return self
     */
    public function isFuture( ) : self
    {
        return $this->status( self::FUTURE );
    }

    /**
     * Indicate that the post status is private
     *
     * It essentially just sets the status to "is_private"
     *
     * @return self
     */
    public function isPrivate( ) : self
    {
        return $this->status( self::IS_PRIVATE );
    }

    /**
     * Indicate that the post status is trash
     *
     * It essentially just sets the status to "trash
     *
     * @return self
     */
    public function isTrash( ) : self
    {
        return $this->status( self::TRASH );
    }

    /**
     * Indicate that the post status is an auto-draft
     *
     * It essentially just sets the status to "auto_draft"
     *
     * @return self
     */
    public function isAutoDraft( ) : self
    {
        return $this->status( self::AUTO_DRAFT );
    }

    /**
     * Indicate that the post status is inherit
     *
     * It essentially just sets the status to "inherit"
     *
     * @return self
     */
    public function inheritStatus( ) : self
    {
        return $this->status( self::INHERIT );
    }

    /**
     * Set the (post) type
     *
     * @param string $type
     * @return self
     */
    public function type( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set the comment status
     *
     * @param string $commentStatus
     * @return $this
     */
    public function commentStatus( string $commentStatus ) : self
    {
        $this->commentStatus = $commentStatus;
        return $this;
    }

    /**
     * Indicate that comments are open for this post
     *
     * It's essentially a shortcut for:
     *  ->commentStatus( Post::COMMENTS_OPEN )
     */
    public function commentsAreOpen( ) : self
    {
        return $this->commentStatus( Post::COMMENTS_OPEN );
    }

    /**
     * Indicate that comments are closed for this post
     *
     * It's essentially a shortcut for:
     *  ->commentStatus( Post::COMMENTS_CLOSED )
     */
    public function commentsAreClosed( ) : self
    {
        return $this->commentStatus( Post::COMMENTS_CLOSED );
    }

    /**
     * Set the ping status
     *
     * @param string $pingStatus
     * @return $this
     */
    public function pingStatus( string $pingStatus ) : self
    {
        $this->pingStatus = $pingStatus;
        return $this;
    }

    /**
     * Indicate that the post is open for pings
     *
     * It's essentially a shortcut for:
     *  ->pingStatus( Post::PINGS_OPEN )
     */
    public function openForPings( ) : self
    {
        return $this->pingStatus( Post::PINGS_OPEN );
    }

    /**
     * Indicate that comments are closed for this post
     *
     * It's essentially a shortcut for:
     *  ->pingStatus( Post::PINGS_CLOSED )
     */
    public function closedForPings( ) : self
    {
        return $this->pingStatus( Post::PINGS_CLOSED );
    }

    /**
     * Set the menu order
     *
     * @param int $order
     * @return Post
     */
    public function menuOrder( int $order ) : self
    {
       $this->menuOrder = $order;
       return $this;
    }

    /**
     * Set the (post) password
     *
     * @param string $password
     * @return Post
     */
    public function password( string $password ) : self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Add an attachment URL
     *
     * @param string $url
     * @return self
     */
    public function addAttachmentUrl( string $url ) : self
    {
        $this->attachmentUrls[ ] = $url;
        return $this;
    }

    /**
     * Set the post's parent
     *
     * @param Post $parent
     * @return Post
     */
    public function parent( Post $parent ) : self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $post = parent::element( );

        if ( $this->id )
        {
            $post->appendChild(
                $this->createElement('wp:post_id', $this->id )
            );
        }

        $this->addDateElements( $post, 'post' );

        if ( $this->status )
        {
            $post->appendChild(
                $this->createElement('wp:status', $this->status )
            );
        }

        if ( $this->commentStatus )
        {
            $post->appendChild(
                $this->createElement('wp:comment_status', $this->commentStatus )
            );
        }

        if ( $this->pingStatus )
        {
            $post->appendChild(
                $this->createElement('wp:ping_status', $this->pingStatus )
            );
        }

        if ( $this->parent )
        {
            $post->appendChild(
                $this->createElement('wp:post_parent', $this->parent->getId( ) )
            );
        }

        if ( $this->menuOrder )
        {
            $post->appendChild(
                $this->createElement('wp:menu_order', $this->menuOrder )
            );
        }

        if ( $this->type )
        {
            $post->appendChild(
                $this->createElement('wp:post_type', $this->type )
            );
        }

        if ( $this->password )
        {
            $post->appendChild(
                $this->createElement('wp:post_password', $this->password )
            );
        }

        if ( count( $this->attachmentUrls ) ) {
            foreach ($this->attachmentUrls as $url)
            {
                $post->appendChild(
                    $this->createElement('wp:attachment_url', $url)
                );
            }
        }

        /**
        if ( count( $this->meta ) ) {
            foreach( $this->meta as $meta )
            {
                $post->appendChild( $meta->element( ) );
            }
        }**/

        // Add the post meta
        $this->addPostMetaElements( $post );

        // Add the terms
        if ( count( $this->terms ) ) {
            foreach( $this->terms as $term ) {
                $post->appendChild( $term->element( ) );
            }
        }

        // Add the comments
        if ( count( $this->comments ) ) {
            foreach( $this->comments as $comment ) {
                $post->appendChild( $comment->element( ) );
            }
        }

        return $post;
    }
}