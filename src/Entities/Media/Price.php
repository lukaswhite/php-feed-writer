<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;

/**
 * Class Price
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Price extends Entity
{
    /**
     * Class constants
     */
    const RENT              =   'rent';
    const PURCHASE          =   'purchase';
    const PACKAGE           =   'package';
    const SUBSCRIPTION      =   'subscription';

    /**
     * The actual price
     *
     * @var float|int
     */
    protected $price;

    /**
     * The type ("rent", "purchase", "package" or "subscription".)
     *
     * @var string
     */
    protected $type;

    /**
     * An optional URL to the pricing information
     *
     * @var string
     */
    protected $info;

    /**
     * The currency
     *
     * @var string
     */
    protected $currency;

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $price = $this->feed->getDocument( )->createElement( 'media:price' );

        if ( $this->price ) {
            $price->setAttribute( 'price', $this->price );
        }

        if ( $this->type ) {
            $price->setAttribute( 'type', $this->type );
        }

        if ( $this->info ) {
            $price->setAttribute( 'info', $this->info );
        }

        if ( $this->currency ) {
            $price->setAttribute( 'currency', $this->currency );
        }

        return $price;
    }

    /**
     * @param float|int $price
     * @return Price
     */
    public function price( $price ) : self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param string $type
     * @return Price
     */
    public function type( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $info
     * @return Price
     */
    public function info( string $info ) : self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @param string $currency
     * @return Price
     */
    public function currency( string $currency )
    {
        $this->currency = $currency;
        return $this;
    }


}