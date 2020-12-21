<?php

namespace Lukaswhite\FeedWriter\Entities\Itunes;

use Lukaswhite\FeedWriter\Entities\Rawvoice\Rawvoice;
use Lukaswhite\FeedWriter\Traits\Rawvoice\HasRawvoice;

/**
 * Class Channel
 *
 * @package Lukaswhite\FeedWriter\Entities\Itunes
 */
class Channel extends AbstractChannel
{
    use HasRawvoice;

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

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $element = parent::element();
        if($this->rawvoice) {
            $this->feed->registerNamespace('rawvoice', Rawvoice::NAMESPACE);
            $this->rawvoice->addTags($element);
        }
        return $element;
    }
}