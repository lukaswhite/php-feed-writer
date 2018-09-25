<?php

namespace Lukaswhite\FeedWriter\Entities\General;

use Lukaswhite\FeedWriter\Entities\Entity;
use Lukaswhite\FeedWriter\Traits\DublinCore\SupportsDublinCore;
use Lukaswhite\FeedWriter\Traits\HasDimensions;
use Lukaswhite\FeedWriter\Traits\HasLink;
use Lukaswhite\FeedWriter\Traits\HasTitle;
use Lukaswhite\FeedWriter\Traits\HasDescription;
use Lukaswhite\FeedWriter\Traits\HasUrl;

/**
 * Class Image
 *
 * @see http://cyber.harvard.edu/rss/rss.html#ltimagegtSubelementOfLtchannelgt
 *
 * @package Lukaswhite\FeedWriter\Helpers
 */
class Image extends Entity
{
    use HasUrl,
        HasLink,
        HasTitle,
        HasDescription,
        HasDimensions,
        SupportsDublinCore;

    /**
     * Create the DOM element that represents this entity.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $image = $this->feed->getDocument( )->createElement( 'image' );

        $this->addUrlElement( $image );

        $this->addTitleElement( $image );

        $this->addDescriptionElement( $image );

        $this->addLinkElement( $image );

        $this->addDimensionsElements( $image );

        $this->addDublinCoreTags( $image );

        return $image;
    }

}