<?php

namespace Lukaswhite\FeedWriter\Traits\Disqus;

/**
 * Trait HasDisqus
 *
 * @package Lukaswhite\FeedWriter\Traits\DublinCore
 */
trait HasDisqus
{
    /**
     * The Disqus thread identifier
     *
     * @var string
     */
    protected $dsqThreadId;

    /**
     * Set the Disqus thread identifier
     *
     * @param string $identifier
     * @return self
     */
    public function disqusThreadIdentifier( string $identifier ) : self
    {
        $this->dsqThreadId = $identifier;
        $this->ensureDisqusNamespaceIsRegistered( );
        return $this;
    }

    /**
     * Ensure that the Disqus namespace is registered. If it isn't, it will do so
     * automatically.
     *
     * @return $this
     */
    protected function ensureDisqusNamespaceIsRegistered( ) : self
    {
        if ( ! $this->feed->isNamespaceRegistered( 'dsq' ) ) {
            $this->feed->registerNamespace(
                'dsq',
                'http://www.disqus.com/'
            );
        }
        return $this;
    }

    /**
     * Add the Disqus tags to the specified element
     *
     * @param \DOMElement $el
     */
    protected function addDisqusTags( \DOMElement $el )
    {
        if ( $this->dsqThreadId ) {
            $el->appendChild( $this->createElement( 'dsq:thread_identifier', $this->dsqThreadId ) );
        }
    }
}