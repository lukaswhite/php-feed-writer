<?php


namespace Lukaswhite\FeedWriter\Entities\Rawvoice\Streams;


use Lukaswhite\FeedWriter\Entities\Rawvoice\Livestream;

/**
 * Class Generic
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice\Streams
 */
class Generic extends Livestream
{
    /**
     * @return string
     */
    protected function getTagName(): string
    {
        return 'liveStream';
    }
}