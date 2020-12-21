<?php


namespace Lukaswhite\FeedWriter\Entities\Rawvoice\Streams;


use Lukaswhite\FeedWriter\Entities\Rawvoice\Livestream;

/**
 * Class Generic
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice\Streams
 */
class Embed extends Livestream
{
    /**
     * @return string
     */
    protected function getTagName(): string
    {
        return 'liveEmbed';
    }
}