<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Itunes
 */
class Channel extends AbstractChannel
{
    protected $categories = [];

    /**
     * Add a category
     *
     * @return Category
     */
    public function addCategory(): Category
    {
        $category = $this->createEntity(Category::class);
        $this->categories[] = $category;
        /** @var Category $category */
        return $category;
    }

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