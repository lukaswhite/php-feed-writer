<?php

namespace Lukaswhite\FeedWriter\Entities\Media;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\HasDimensions;

/**
 * Class Restriction
 *
 * @package Lukaswhite\FeedWriter\Entities
 */
class Restriction extends Entity
{
    /**
     * Class constants
     */
    const ALLOW             =   'allow';
    const DENY              =   'deny';

    const COUNTRY           =   'country';
    const URI               =   'uri';
    const SHARING           =   'sharing';

    /**
     * The relationship (allow / deny)
     *
     * @var string
     */
    protected $relationship = self::DENY;

    /**
     * The type of restriction (country / uri / sharing)
     *
     * @var string
     */
    protected $type;

    /**
     * The country (ISO 3166)
     *
     * @var string
     */
    protected $country;

    /**
     * The URI
     *
     * @var string
     */
    protected $uri;

    /**
     * Indicate that we're stating that this is allowed
     *
     * @return $this
     */
    public function allow( ) : self
    {
        $this->relationship = self::ALLOW;
        return $this;
    }

    /**
     * Indicate that the restriction is denying
     *
     * @return $this
     */
    public function deny( ) : self
    {
        $this->relationship = self::DENY;
        return $this;
    }

    /**
     * Indicate that the restriction is by country
     *
     * @var string The countrie(s)
     * @return $this
     */
    public function byCountry( string $country ) : self
    {
        $this->type = self::COUNTRY;
        $this->country = $country;
        return $this;
    }

    /**
     * Indicate that the restriction is on sharing
     *
     * @return $this;
     */
    public function onSharing( ) : self
    {
        $this->type = self::SHARING;
        return $this;
    }

    /**
     * Indicate that this restriction is based on URI
     *
     * @param string $uri
     * @return $this
     */
    public function byUri( string $uri ) : self
    {
        $this->uri = $uri;
        $this->type = self::URI;
        return $this;
    }

    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        switch ( $this->type ) {
            case self::SHARING:
                $restriction = $this->createElement( 'media:restriction' );
                break;
            case self::COUNTRY:
                $restriction = $this->createElement( 'media:restriction', $this->country );
                break;
            case self::URI:
                $restriction = $this->createElement( 'media:restriction', $this->uri );
                break;
        }

        $restriction->setAttribute( 'relationship', $this->relationship );
        $restriction->setAttribute( 'type', $this->type );

        return $restriction;
    }
}