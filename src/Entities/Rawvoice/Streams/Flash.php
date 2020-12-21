<?php


namespace Lukaswhite\FeedWriter\Entities\Rawvoice\Streams;


use Lukaswhite\FeedWriter\Entities\Rawvoice\Livestream;

/**
 * Class Flash
 * @package Lukaswhite\FeedWriter\Entities\Rawvoice\Streams
 */
class Flash extends Livestream
{
    /**
     * @return string
     */
    protected function getTagName(): string
    {
        return 'flashLiveStream';
    }
}