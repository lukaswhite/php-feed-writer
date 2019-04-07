<?php

namespace Lukaswhite\FeedWriter\Traits\Wxr;


use Lukaswhite\FeedWriter\Entities\Wxr\TermMeta;

/**
 * Trait HasTermMeta
 *
 * @package Lukaswhite\FeedWriter\Traits\Wxr
 */
trait HasTermMeta
{
    /**
     * The meta
     *
     * @var array
     */
    protected $meta = [ ];

    /**
     * Add term meta
     *
     * @return TermMeta
     */
    public function addTermMeta( )
    {
        $meta = $this->createEntity( TermMeta::class );
        /** @var TermMeta $meta */
        $this->meta[ ] = $meta;
        return $meta;
    }

    /**
     * Add the term meta to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addTermMetaElements( \DOMElement $el ) : void
    {
        if ( count( $this->meta ) ) {
            foreach( $this->meta as $meta ) {
                $el->appendChild( $meta->element( ) );
            }
        }
    }
}