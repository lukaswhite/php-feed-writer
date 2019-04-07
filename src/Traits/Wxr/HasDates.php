<?php

namespace Lukaswhite\FeedWriter\Traits\Wxr;


use Lukaswhite\FeedWriter\Entities\Wxr\TermMeta;

/**
 * Trait HasDates
 *
 * @package Lukaswhite\FeedWriter\Traits\Wxr
 */
trait HasDates
{
    /**
     * The date
     *
     * @var \DateTime
     */
    protected $date;

    /**
     * The date, in GMT
     *
     * @var \DateTime
     */
    protected $dateGmt;

    /**
     * Set the date
     *
     * Passing true as the second argument specifies that the date is already in GMT.
     *
     * @param \DateTime $date
     * @param bool $isGmt
     * @return $this
     */
    public function date( \DateTime $date, $isGmt = false )
    {
        $this->date = $date;
        if ( $isGmt ) {
            $this->dateGmt = $date;
        }
        return $this;
    }

    /**
     * Set the date in GMT format
     *
     * @param \DateTime $date
     * @return $this
     */
    public function dateGmt( \DateTime $date )
    {
        $this->dateGmt = $date;
        return $this;
    }

    /**
     * Add the dates to the specified element.
     *
     * @param \DOMElement $el
     * @param string $type
     * @return void
     */
    protected function addDateElements( \DOMElement $el, $type ) : void
    {
        if ( $this->date ) {
            $el->appendChild(
                $this->createElement(
                    $type === 'post' ? 'wp:post_date' : 'wp:comment_date',
                    $this->date->format('Y-m-d H:i:s' )
                )
            );
        }
        if ( $this->dateGmt ) {
            $el->appendChild(
                $this->createElement(
                    $type === 'post' ? 'wp:post_date_gmt' : 'wp:comment_date_gmt',
                    $this->dateGmt->format( 'Y-m-d H:i:s' )
                )
            );
        }
    }
}