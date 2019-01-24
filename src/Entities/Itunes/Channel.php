<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Itunes
 */
class Channel extends AbstractChannel
{
    /**
     * Add an item
     *
     * @return Item
     */
    public function addItem( ) : Item
    {
        $item = $this->createEntity( Item::class );
        /** @var Item $item */
        $this->items[ ] = $item;
        return $item;
    }
}