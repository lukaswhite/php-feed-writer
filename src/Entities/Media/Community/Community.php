<?php

namespace Lukaswhite\FeedWriter\Entities\Media\Community;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Community
 *
 * @package Lukaswhite\FeedWriter\Entities\Media\Community
 */
class Community extends Entity
{
    /**
     * The star rating
     *
     * @var StarRating
     */
    protected $starRating;

    /**
     * The statistics
     *
     * @var Statistics
     */
    protected $statistics;

    /**
     * The user-generated tags
     *
     * @var array
     */
    protected $tags = [ ];

    /**
     * Add a star rating
     *
     * @return StarRating
     */
    public function addStarRating( ) : StarRating
    {
        $this->starRating = new StarRating( $this->feed );
        return $this->starRating;
    }

    /**
     * Add some statistics
     *
     * @return Statistics
     */
    public function addStatistics( ) : Statistics
    {
        $this->statistics = new Statistics( $this->feed );
        return $this->statistics;
    }

    /**
     * Add a tag
     *
     * @param string $name
     * @param int $weight
     * @return self
     */
    public function addTag( string $name, $weight = null ) : self
    {
        $tag = ( new Tag( ) )->name( $name );
        if ( $weight ) {
            $tag->weight( $weight );
        }
        $this->tags[ ] = $tag;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $community = $this->createElement( 'media:community' );

        if ( $this->starRating ) {
            $community->appendChild( $this->starRating->element( ) );
        }

        if ( $this->statistics ) {
            $community->appendChild( $this->statistics->element( ) );
        }

        if ( count( $this->tags ) ) {

            // The tags should be ascending order of weight
            uasort(
                $this->tags,
                function( Tag $a, Tag $b ) {
                    if ( $a->getWeight( ) == $b->getWeight( ) ) {
                        return strcmp( $a->getName( ), $b->getName( ) );
                    }
                    return ( $a->getWeight( ) < $b->getWeight( ) ) ? 1 : -1;
                }
            );

            // Now render the tags as a comma-separated string, in the form name:weight
            // (There's no need to include the weight if it's the default, 1)
            $community->appendChild(
                $this->createElement(
                    'media:tags',
                    implode(
                        ', ',
                        array_map( function( Tag $tag ) {
                            return $tag->toString( );
                        }, $this->tags
                    )
                )
            ) );
        }

        return $community;
    }

}