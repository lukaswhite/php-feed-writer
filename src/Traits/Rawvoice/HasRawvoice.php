<?php

namespace Lukaswhite\FeedWriter\Traits\Rawvoice;

use Lukaswhite\FeedWriter\Entities\Rawvoice\Rawvoice;

/**
 * Trait HasRawvoice
 *
 * @package Lukaswhite\FeedWriter\Traits\Rawvoice
 */
trait HasRawvoice
{
    /**
     * The Rawvoice helper
     *
     * @var Rawvoice
     */
    protected $rawvoice;

    /**
     * Get the Rawvoice helper
     *
     * @return Rawvoice
     */
    public function rawvoice( )
    {
        if ( ! $this->rawvoice ) {
            $this->rawvoice = new Rawvoice( $this->feed );
        }
        return $this->rawvoice;
    }

}