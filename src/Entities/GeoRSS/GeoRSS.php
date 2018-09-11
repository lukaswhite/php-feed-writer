<?php

namespace Lukaswhite\FeedWriter\Entities\GeoRSS;

use Lukaswhite\FeedWriter\Feed;
use Lukaswhite\FeedWriter\Traits\CreatesDOMElements;

/**
 * Class GeoRSS
 *
 * @package Lukaswhite\FeedWriter\Entities\GeoRSS
 */
class GeoRSS
{
    use CreatesDOMElements;

    public function __construct( Feed $feed )
    {
        $this->feed = $feed;
    }

    /**
     * The feed
     *
     * @var Feed
     */
    protected $feed;

    /**
     * The geographical location
     *
     * @var Location
     */
    protected $location;

    /**
     * The GeoRSS feature type; e.g. city
     *
     * @var string
     */
    protected $featureType;

    /**
     * The name of a GeoRSS feature
     *
     * @var string
     */
    protected $featureName;

    /**
     * The GeoRSS relationship tag; e.g. is-centered-at
     *
     * @var string
     */
    protected $relationshipTag;

    /**
     * The GeoRSS elevation
     *
     * @var integer
     */
    protected $elevation;

    /**
     * The GeoRSS floor
     *
     * @var integer
     */
    protected $floor;

    /**
     * The GeoRSS radius
     *
     * @var integer
     */
    protected $radius;

    /**
     * Add a GeoRSS point
     *
     * @param float $lat
     * @param float $lng
     * @return self
     */
    public function addPoint( float $lat, float $lng ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->location = ( new Point( $this->feed ) )
            ->lat( $lat )
            ->lng( $lng );
        return $this;
    }

    /**
     * Add a GeoRSS line
     *
     * @param string $points
     * @return self
     */
    public function addLine( string $points ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->location = ( new Line( $this->feed ) )
            ->points( $points );
        return $this;
    }

    /**
     * Add a GeoRSS polygon
     *
     * @param string $points
     * @return self
     */
    public function addPolygon( string $points ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->location = ( new Polygon( $this->feed ) )
            ->points( $points );
        return $this;
    }

    /**
     * Add a GeoRSS box
     *
     * @param string $points
     * @return self
     */
    public function addBox( string $points ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->location = ( new Box( $this->feed ) )
            ->points( $points );
        return $this;
    }

    /**
     * @param string $featureType
     * @return self
     */
    public function featureType( string $featureType ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->featureType = $featureType;
        return $this;
    }

    /**
     * @param string $featureName
     * @return self
     */
    public function featureName( string $featureName ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->featureName = $featureName;
        return $this;
    }

    /**
     * @param string $relationshipTag
     * @return self
     */
    public function relationshipTag( string $relationshipTag ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->relationshipTag = $relationshipTag;
        return $this;
    }

    /**
     * @param int $elevation
     * @return self
     */
    public function elevation( int $elevation ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->elevation = $elevation;
        return $this;
    }

    /**
     * @param int $floor
     * @return self
     */
    public function floor( int $floor ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->floor = $floor;
        return $this;
    }

    /**
     * @param int $radius
     * @return self
     */
    public function radius( int $radius ) : self
    {
        $this->ensureGeoRssNamespaceIsRegistered( );
        $this->radius = $radius;
        return $this;
    }

    /**
     * Indicate that, for the purposes of GeoRSS, this entity is centered on the specified
     * point
     *
     * @param float $lat
     * @param float $lng
     * @return self
     */
    public function isCenteredOnPoint( float $lat, float $lng ) : self
    {
        $this->addPoint( $lat, $lng );
        $this->relationshipTag( 'is-centered-on' );
        return $this;
    }

    /**
     * Add the GeoRSS tags to the specified element
     *
     * @param \DOMElement $el
     */
    public function addTags( \DOMElement $el )
    {
        if ( $this->location ) {
            $el->appendChild( $this->location->element( ) );
        }
        if ( $this->featureName ) {
            $el->appendChild( $this->createElement( 'georss:featurename', $this->featureName ) );
        }
        if ( $this->featureType ) {
            $el->appendChild( $this->createElement( 'georss:featuretypetag', $this->featureType ) );
        }
        if ( $this->relationshipTag ) {
            $el->appendChild( $this->createElement( 'georss:relationshiptag', $this->relationshipTag ) );
        }
        if ( $this->radius ) {
            $el->appendChild( $this->createElement( 'georss:radius', $this->radius ) );
        }
        if ( $this->elevation ) {
            $el->appendChild( $this->createElement( 'georss:elev', $this->elevation ) );
        }
        if ( $this->floor ) {
            $el->appendChild( $this->createElement( 'georss:floor', $this->floor ) );
        }
    }

    /**
     * Ensure that the GeoRSS namespace is registered. If it isn't, it will do so
     * automatically.
     *
     * @return $this
     */
    protected function ensureGeoRssNamespaceIsRegistered( ) : self
    {
        if ( ! $this->feed->isNamespaceRegistered( 'georss' ) ) {
            $this->feed->registerGeoRSSNamespace( );
        }
        return $this;
    }
}