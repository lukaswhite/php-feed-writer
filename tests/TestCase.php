<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\RSSWriter\SimpleXMLElement;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function xmlHasOneElementNamed( $name, $xml )
    {
        $xpath = new \DOMXPath($xml);

        $query = sprintf( '//%s', $name );
        $entries = $xpath->query($query);
        return count( $entries ) == 1;
    }

    protected function getAttributesOfElementNamed( $name, $str )
    {
        $doc = new \DOMDocument( );
        $doc->loadXML( trim( $str ) );
        $xpath = new \DOMXPath($doc);
        $query = sprintf( '//%s', $name );
        $entries = $xpath->query( $query );
        $attributes = [ ];
        foreach( $entries[ 0 ]->attributes as $attribute ) {
            $attributes[ $attribute->name ] = $attribute->value;
        }
        return $attributes;
    }

}