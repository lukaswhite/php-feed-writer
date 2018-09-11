# Feed Writer

A PHP library for writing feeds. Currently supports RSS 2.0, Atom and iTunes.

## Features

* Lightning Fast
* Modern &mdash; uses PHP7
* Flexible; use it for syndication, media, podcasts...
* Easy to extend
* Supports custom namespaces
* Full MediaRSS support
* GeoRSS support
* Supports XSL stylesheets
* No third-party dependencies
* Fully tested

## Simple Examples

### RSS


```php
$feed = new RSS2( );

$channel = $feed->addChannel( );

$channel
	->title( 'My Blog' )
	->description( 'My personal blog' )
	->link( 'https://example.com' )
	->lastBuildDate( new \DateTime( ) )
	->pubDate( new \DateTime( ) )
	->language( 'en-US' );

foreach( $posts as $post ) {
	$channel->addItem( )
		->title( $post->title )
		->description( $post->description )
		->link( $post->url )
		->pubDate( $post->publishedAt )
		->guid( $post->url, true );
}
```

### Atom

```php
$feed = new \Lukaswhite\FeedWriter\Atom( );

$feed->title( 'Example Feed' )
	->link( 'http://example.org/' )
	->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
	->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );
	
foreach( $posts as $post ) {
	$feed->addEntry( )
		->title( $post->title )
		->id( $post->id )
		->updated( $post->updatedAt );
}
```

### iTunes

```php
$feed = new Itunes( );

$channel = $feed->addChannel( );

$channel->title( 'All About Everything' )
    ->subtitle( 'A show about everything' )
    ->description( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store' )
    ->summary( 'All About Everything is a show about everything. Each week we dive into any subject known to man and talk about it as much as we can. Look for our podcast in the Podcasts app or in the iTunes Store' )
    ->link( 'http://www.example.com/podcasts/everything/index.html' )
    ->image( 'http://example.com/podcasts/everything/AllAboutEverything.jpg' )
    ->author( 'John Doe' )
    ->owner( 'John Doe', 'john.doe@example.com' )
    ->explicit( 'no' )
    ->copyright( '&#x2117; &amp; &#xA9; 2014 John Doe &amp; Family' )
    ->generator( 'Feed Writer' )
    ->ttl( 60 )
    ->lastBuildDate( new \DateTime( '2016-03-10 02:00' ) );

$channel->addItem( )
    ->title( 'Shake Shake Shake Your Spices' )
    ->author( 'John Doe' )
    ->subtitle( 'A short primer on table spices' )
    ->duration( '07:04' )
    ->summary( 'This week we talk about <a href="https://itunes/apple.com/us/book/antique-trader-salt-pepper/id429691295?mt=11">salt and pepper shakers</a>, comparing and contrasting pour rates, construction materials, and overall aesthetics. Come and join the party!' )
    ->pubDate( new \DateTime( '2016-03-08 12:00' ) )
    ->guid( 'http://example.com/podcasts/archive/aae20140615.m4a' )
    ->explicit( 'no' )
    ->addEnclosure( )
        ->url( 'http://example.com/podcasts/everything/AllAboutEverythingEpisode3.m4a' )
        ->length( 8727310 )
        ->type( 'audio/x-m4a' );
```

## Installation

This package requires PHP 7+.

Install the packae using [Composer](https://getcomposer.org/):

```
composer require lukaswhite\php-feed-writer
```

## Documentation

Full documentation [can be found here](https://lukaswhite.github.io/php-feed-writer/#/?id=installation).