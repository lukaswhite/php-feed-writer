<?php


namespace Lukaswhite\FeedWriter\Entities\Rawvoice\Streams;


use Lukaswhite\FeedWriter\Entities\Rawvoice\Livestream;

/**
 * Class Shoutcast
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice\Streams
 */
class Shoutcast extends Livestream
{
    /**
     * @return string
     */
    protected function getTagName(): string
    {
        return 'shoutcastLiveStream';
    }
}