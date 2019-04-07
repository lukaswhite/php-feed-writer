<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;
use Lukaswhite\FeedWriter\Entities\Disqus\Remote;
use Lukaswhite\FeedWriter\Traits\Wxr\HasDates;


/**
 * Class Comment
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
class Comment extends \Lukaswhite\FeedWriter\Entities\Entity
{
    use HasDates;


    /**
     * Class constants for the comment type
     */
    const COMMENT       =   'comment';
    const TRACKBACK     =   'trackback';
    const PINGBACK      =   'pingback';

    /**
     * The ID of the comment
     *
     * @var integer
     */
    protected $id;

    /**
     * The comment status
     *
     * @var string
     */
    protected $status;

    /**
     * The author of the comment
     *
     * @var string
     */
    protected $author;

    /**
     * The author's e-mail address
     *
     * @var string
     */
    protected $authorEmail;

    /**
     * The author's URL
     *
     * @var string
     */
    protected $authorUrl;

    /**
     * The IP address of the author
     *
     * @var string
     */
    protected $authorIp;

    /**
     * The content (body) of the comment
     *
     * @var string
     */
    protected $content;

    /**
     * The type of comment
     *
     * @var string
     */
    protected $type;

    /**
     * Whether the comment has been approved
     *
     * @var bool
     */
    protected $approved;

    /**
     * The parent
     *
     * @var Comment
     */
    protected $parent;

    /**
     * the user ID
     *
     * @var int
     */
    protected $userId;

    /**
     * The Disqus user
     *
     * @var Remote
     */
    protected $remote;

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
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $comment = $this->createElement( 'wp:comment' );

        if ( $this->id ) {
            $comment->appendChild(
                $this->createElement('wp:comment_id', $this->id )
            );
        }

        $this->addDateElements( $comment, 'comment' );

        if ( $this->status ) {
            $comment->appendChild(
                $this->createElement('wp:comment_status', $this->status )
            );
        }

        if ( $this->author ) {
            $comment->appendChild(
                $this->createElement('wp:comment_author', $this->author )
            );
        }

        if ( $this->authorEmail ) {
            $comment->appendChild(
                $this->createElement('wp:comment_author_email', $this->authorEmail )
            );
        }

        if ( $this->authorUrl ) {
            $comment->appendChild(
                $this->createElement('wp:comment_author_url', $this->authorUrl )
            );
        }

        if ( $this->authorIp ) {
            $comment->appendChild(
                $this->createElement('wp:comment_author_IP', $this->authorIp )
            );
        }

        if ( $this->content ) {
            $comment->appendChild(
                $this->createElement('wp:comment_content', $this->content )
            );
        }

        if ( isset( $this->approved ) ) {
            $comment->appendChild(
                $this->createElement('wp:comment_approved', $this->approved ? 1 : 0 )
            );
        }

        if ( $this->type ) {
            $comment->appendChild(
                $this->createElement('wp:comment_type', $this->type )
            );
        }

        if ( $this->parent ) {
            $comment->appendChild(
                $this->createElement('wp:comment_parent', $this->parent->getId( ) )
            );
        }

        if ( $this->userId ) {
            $comment->appendChild(
                $this->createElement('wp:comment_user_id', $this->userId )
            );
        }

        if ( $this->remote ) {
            $comment->appendChild( $this->remote->element( ) );
        }

        return $comment;
    }

    /**
     * Set the ID
     *
     * @param int $id
     * @return self
     */
    public function id( int $id ) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the author
     *
     * @param string $author
     * @return self
     */
    public function author( string $author ) : self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Set the author Email
     *
     * @param string $authorEmail
     * @return self
     */
    public function authorEmail( string $authorEmail ) : self
    {
        $this->authorEmail = $authorEmail;
        return $this;
    }

    /**
     * Set the author URL
     *
     * @param string $authorUrl
     * @return self
     */
    public function authorUrl( string $authorUrl ) : self
    {
        $this->authorUrl = $authorUrl;
        return $this;
    }

    /**
     * Set the author's IP address
     *
     * @param string $authorIp
     * @return self
     */
    public function authorIp( string $authorIp ) : self
    {
        $this->authorIp = $authorIp;
        return $this;
    }

    /**
     * Set the status
     *
     * @param string $status
     * @return self
     */
    public function status( string $status ) : self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Indicate that the comment is open; this is a shortcut for setting
     * the status to "open"
     *
     * @return self
     */
    public function isOpen( ) : self
    {
        return $this->status( 'open' );
    }

    /**
     * Indicate that the comment is closed; this is a shortcut for setting
     * the status to "closed"
     *
     * @return self
     */
    public function isClosed( ) : self
    {
        return $this->status( 'closed' );
    }

    /**
     * Set the type
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
     * Indicate that the comment is of type "comment"
     *
     * @return self
     */
    public function isComment( ) : self
    {
        return $this->type( self::COMMENT );
    }

    /**
     * Indicate that the comment is of type "trackback"
     *
     * @return self
     */
    public function isTrackback( ) : self
    {
        return $this->type( self::TRACKBACK );
    }

    /**
     * Indicate that the comment is of type "pingback"
     *
     * @return self
     */
    public function isPingback( ) : self
    {
        return $this->type( self::PINGBACK );
    }

    /**
     * Set the parent
     *
     * @param Comment $parent
     * @return Comment
     */
    public function parent( Comment $parent ) : self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Set the user ID
     *
     * @param int $userId
     * @return self
     */
    public function userId( int $userId ) : self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Set the approved property
     *
     * @param bool $approved
     * @return $this
     */
    public function approved( $approved = true )
    {
        $this->approved = $approved;
        return $this;
    }

    /**
     * Indicate that the comment has been approved
     *
     * @return $this
     */
    public function hasBeenApproved( )
    {
        return $this->approved( );
    }

    /**
     * Indicate that the comment has not been approved
     *
     * @return $this
     */
    public function hasNotBeenApproved( )
    {
        return $this->approved( false );
    }

    /**
     * Set the content of the comment
     *
     * @param string $content
     * @return self
     */
    public function content( string $content ) : self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Add a remote Disqus user
     *
     * @return Remote
     */
    public function addRemote( ) : Remote
    {
        $this->remote = $this->createEntity( Remote::class );
        return $this->remote;
    }

}