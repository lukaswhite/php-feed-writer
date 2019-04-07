<?php

namespace Lukaswhite\FeedWriter\Traits\Wxr;


use Lukaswhite\FeedWriter\Entities\Wxr\PostMeta;

/**
 * Trait HasPostMeta
 *
 * @package Lukaswhite\FeedWriter\Traits\Wxr
 */
trait HasPostMeta
{
    /**
     * The meta
     *
     * @var array
     */
    protected $meta = [ ];

    /**
     * Add post meta
     *
     * @return PostMeta
     */
    public function addPostMeta( ) : PostMeta
    {
        $meta = $this->createEntity( PostMeta::class );
        /** @var PostMeta $meta */
        $this->meta[ ] = $meta;
        return $meta;
    }

    /**
     * Add the term meta to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addPostMetaElements( \DOMElement $el ) : void
    {
        if ( count( $this->meta ) ) {
            foreach( $this->meta as $meta ) {
                $el->appendChild( $meta->element( ) );
            }
        }
    }
}