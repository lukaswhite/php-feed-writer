<?php

namespace Lukaswhite\FeedWriter\Entities\Media\Community;

/**
 * Class Tag
 *
 * @package Lukaswhite\FeedWriter\Entities\Media\Community
 */
class Tag
{
    /**
     * The name of the tag
     *
     * @var string
     */
    protected $name;

    /**
     * The weight; for example the number of users who have assigned it
     *
     * @var int
     */
    protected $weight;

    /**
     * Set the name of the tag
     *
     * @param string $name
     * @return self
     */
    public function name( string $name ) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the weight; for example the number of users who have assigned it
     *
     * @param int $weight
     * @return self
     */
    public function weight( int $weight ) : self
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Get the tag's name
     *
     * @return string
     */
    public function getName( ) : string
    {
        return $this->name;
    }

    /**
     * Get the tag's weight
     *
     * @return int
     */
    public function getWeight( ) : int
    {
        return ( $this->weight ) ? $this->weight : 1;
    }

    /**
     * Create a string representation of this tag
     *
     * @return string
     */
    public function toString( )
    {
        $str = $this->name;

        if ( ! $this->weight || $this->weight == 1 ) {
            return $str;
        }

        return sprintf( '%s:%d', $this->name, $this->weight );
    }

}