<?php

namespace Lukaswhite\FeedWriter\Entities\Wxr;
use Lukaswhite\FeedWriter\Traits\Wxr\HasTermId;
use Lukaswhite\FeedWriter\Traits\Wxr\HasTermMeta;

/**
 * Class Tag
 *
 * @package Lukaswhite\FeedWriter\Entities\Wxr
 */
class Tag extends \Lukaswhite\FeedWriter\Entities\Entity
{
    use     HasTermId
        ,   HasTermMeta;

    /**
     * The slug
     *
     * @var string
     */
    protected $slug;

    /**
     * The name of the tag
     *
     * @var string
     */
    protected $name;

    /**
     * A description of the tag
     *
     * @var string
     */
    protected $description;

    /**
     * Tag metadata
     *
     * @var array
     */
    protected $meta = [ ];

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $tag = $this->createElement( 'wp:tag' );

        $this->addTermIdElement( $tag );

        if ( $this->slug )
        {
            $tag->appendChild(
                $this->createElement('wp:tag_slug', $this->slug )
            );
        }

        if ( $this->name ) {
            $tag->appendChild(
                $this->createElement('wp:tag_name', $this->name )
            );
        }

        if ( $this->description ) {
            $tag->appendChild(
                $this->createElement('wp:tag_description', $this->description )
            );
        }

        $this->addTermMetaElements( $tag );

        return $tag;
    }

    /**
     * Set the name
     *
     * @param string $name
     * @return self
     */
    public function name( $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the slug
     *
     * @param string $slug
     * @return self
     */
    public function slug( $slug ) : self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Set the description
     *
     * @param string $description
     * @return self
     */
    public function description( $description ) : self
    {
        $this->description = $description;
        return $this;
    }

}