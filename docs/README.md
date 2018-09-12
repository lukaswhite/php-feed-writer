# Feed Writer

<img src="https://lukaswhite.github.io/php-feed-writer/assets/php-feed-writer.svg" width="120px" alt="PHP Feed Writer">

A PHP library for writing feeds. Currently supports RSS 2.0, Atom and iTunes.

> **Important** &mdash; This is a work in progress

## Features

* Modern (PHP7+)
* Flexible; use it for syndication, media, podcasts...
* Fast
* Easy to extend
* Supports custom namespaces
* Full MediaRSS support
* GeoRSS support
* Supports XSL stylesheets
* No third-party dependencies
* Fully tested

## Simple Examples

Sometimes a library is best introduced with some simple examples. Note that these don't demonstrate the full range of capabilities.

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

print $feed;
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

print $feed;
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
        
print $feed;
```

## Installation

This package requires PHP 7+.

Install the package using [Composer](https://getcomposer.org/):

```
composer require lukaswhite\php-feed-writer
```

## RSS

### Creating a Feed

To create a feed:

```php
use Lukaswhite\FeedWriter\Feed;

$feed = new RSS2( );
```

This creates a feed with the `utf-8` character encoding; to override that:

```php
$feed = new RSS2( 'iso-8859-1' );
```

#### Feed Namespaces

By default, the `content` namespace is set (`http://purl.org/rss/1.0/modules/content/`).

To register a new namespace:

```php
$feed->registerNamespce( 'dc', 'http://purl.org/dc/elements/1.1/' );
```

For convenience, the following common namespaces have their own corresponding methods:

```php
$feed->registerAtomNamespace( );
$feed->registerMediaNamespace( );
$feed->registerDublinCoreNamespace( );
$feed->registerGeoRSSNamespace( );
```

To check whether a namespace is registered:

```php
$registered = $feed->isNamespaceRegistered( 'name' );
```

To unregister a namespace &mdash; for example, if for whatever reason you don't want the `content` namespace set &mdash; simply do this:

```php
$channel->unregisterNamespace( 'content' );
```

Note that the Atom and Media namespaces are automatically added by this class when you add an atom link or some media respectively.

### Creating a Channel

A call to `addChanel` creates a new channel, adds it to the feed and returns it.

```php
$channel = $feed->addChannel( );
```

From there, the `Channel` class provides a number of methods for settings its attributes using a fluent interface.

#### Setting a Channel's Title

```php
$channel->title( 'My Blog' );
```

#### Setting a Channel's Description

```php
$channel->description( 'My personal blog' );
```

If you want the description to be character encoded &mdash; i.e. wrapped in a `CDATA` section &mdash; then pass `true` as a second argument. If you don't, it will attempt to guess whether it should do so, by attempting to detect HTML in the provided description.

#### Setting a Channel's Link

```php
$channel->link( 'https://example.com' );
```

#### Setting a Channel's Language

```php
$channel->language( 'en-GB' );
```

#### Setting a Channel's Copyright Notice

```php
$channel->copyright( 'Copyright 2018 Me' );
```

#### Setting a Channel's Last Build Date


```php
$channel->lastBuildDate( new \DateTime( ) );
```

> If you use the excellent [Carbon](https://carbon.nesbot.com/docs/) library then, since it's an extension of `\DateTime`, you can simply pass an instance of that. It's not a required package, however.

#### Setting a Channel's Published Date

```php
$channel->pubDate( new \DateTime( ) );
```

> If you use the excellent [Carbon](https://carbon.nesbot.com/docs/) library then, since it's an extension of `\DateTime`, you can simply pass an instance of that. It's not a required package, however.

#### Setting a Channel's Categories

There are two ways to set a channel's categories. You can set multiple categories like this:

```php
$channel->categories( 'PHP', 'development', 'programming' );
```

The limitation of that, though, is that you cannot set the domain attribute; if you need to do that then simply use the `addCategory` method and pass the domain as the second argument:

```php
$channel->addCategory( 'PHP', 'the domain' );
```

The second argument is optional, so the previous example can be re-written as follows:

```php
$channel
	->addCategory( 'PHP' )
	->addCategory( 'development' )
	->addCategory( 'programming' );
```

#### Adding Links

You can add a link to the feed like this:

```php
$channel->addLink(
	'atom:link',
	'https://example.com/feed.xml',
	'self', // the rel attribute
	'application/atom+xml'
);
```

For convenience, you can add an Atom link as follows:

```php
$channel->addAtomLink( 'https://example.com/feed.xml' );
```

This will automatically register the appropriate namespace for you.

#### PubSubHubbub

To add a PubSubHubbub link:

```php
$channel->addPubSubHubbubLink( 'http://pubsubhubbub.appspot.com' );
```

If you need more flexibility, just use `addLink` directly. For example the line above does this:

```php
$this->addLink(
	'atom:link',
	'http://pubsubhubbub.appspot.com',
	'hub'
);	
```

#### Adding Images

You can add an image to a channel by calling `addImage()`:

```php
->addImage( )
	->url( 'http://example.com/image.jpeg' )
	->link( 'http://example.com' )
	->title( 'An example image')
	->width( 200 )
	->height( 150 );
```

> You can also add images using MediaRSS.

#### Setting the Generator

The generator specifies the software used to generate the feed:

```php
$channel->generator( 'PHP Feed Writer (https://github.com/lukaswhite/php-feed-writer)' )
```

If you find this package useful, please consider setting it!

#### Other Channel Properties

There are a few other miscellaneous properties of the channel object [defined in the spec](http://www.rssboard.org/rss-profile#element-channel) and implemented for completeness. All are optional, and may or may not be observed by various feed readers.

```php
$channel->author( 'author@example.com' )
	->webmaster( 'webmaster@example.com' )
	->managingEditor( 'editor@example.com (the editor)' )
	->rating( '(PICS-1.1 "http://www.rsac.org/ratingsv01.html" l by "webmaster@example.com" on "2007.01.29T10:09-0800" r (n 0 s 0 v 0 l 0))' )
	->skipDays( 'Saturday', 'Sunday' )
	->skipHours( 0, 1, 2, 3, 4 )
	->ttl( 60 );
```

> Note that the `author`, `webmaster` and `managingEditor` elements must contain an e-mail address, not just a name.

### Adding Items

Now that your feed has a channel, it's time to start adding items.

To add an item to the channel, call `addItem()`. This creates a new instance, attaches it to the feed and returns it. Like channels, the `Item` class has a fluent interface that you can use to set the appropriate properties.

#### Setting the Item's title

```php
$channel->addItem( )
	->title( 'A Blog Post' );
```	

#### Setting the Item's description

```php
$item->description( 'Just a post, on a blog' );
```	

> This behaves in the same way as the channel descripton with respect to character encoding; see the section on that for details.

#### Setting the Item's Link

```php
$item->link( 'http://example.com/blog/post-1.html' )
```	

#### Setting the GUID of the Item

```php
$item->guid( 'http://example.com/blog/post-1.html' )
```	

If the GUID is a permalink, pass true as the second argument:

```php
$item$entry->guid( 'http://example.com/blog/post-1.html' )
```	

The result will be:

```xml
<guid isPermalink="true">http://example.com/blog/post-1.html</guid>
```

#### Setting Item's Published Date

```php
$item->pubDate( new \DateTime( '2018-09-07 09:30' ) );
```

#### Setting the Content of an Item

RSS2.0 allows you to incoporate the full content of an item; for example the whole of a blog post. 

You can add this as follows:

```php
$item->encodedContent( '<p>The content of the item</p>' );
```

> Fro the spec; "the content MUST be suitable for presentation as HTML"

#### Adding Enclosures

To add an enclosure; for example a link to an item of audio:

```php
$item->addEnclosure( )
	->url( 'http://example.com/audio.mp3' )
	->length( 1000 )
	->type( 'audio/mpeg' );
```	

#### Adding Media

Please see the section on MediaRSS.

## Atom

You can use this library to create Atom feeds.

### Creating a Feed

To create an Atom feed:

```php
$feed = new Atom( );
```

By default, the character encoding is set to `utf-8`; however you can override that like this:

```php
$feed = new Atom( 'iso-8859-1' );
```

### Required Feed Elements

#### Setting the Feed's Title

To set the title of the feed:

```php
$feed->title( 'Example Feed' );
```

The method takes an optional second parameter to specify the type; e.g. `plain` (the default) or `html`. [Click here](https://validator.w3.org/feed/docs/atom.html#text) for an explanation.

For example:

```php
$feed->title( 'Example <strong>Feed</strong>', 'html' );
```

#### Setting the Feed's ID

Atom feeds require an ID. From the spec: [the ID] identifies the feed using a universally unique and permanent URI. You can also use a URN ([Uniform Resource Name](https://en.wikipedia.org/wiki/Uniform_Resource_Name)) if you prefer.

```php
$feed->id( 'urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6' );
```

#### Specifying when the Feed was Updated

The third and final required piece of information on an Atom feed is "the time that the feed was last modified in a significant way":

```php
$feed->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );
```

### Recommended Feed Elements

#### Specifying the Feed's Author(s)

You can specify one or more authors of a feed by calling the `addAuthor()` method, which returns an instance of a class named `Person`. [Refer to the spec](https://validator.w3.org/feed/docs/atom.html#person) for an explanation.

Once you have that instance you can set the name, e-mail address or / and a URI using the following methods:

```php
$feed->addAuthor( )
	->name( 'John Doe' )
	->email( 'john@doe.com' )
	->uri( 'http://doe.com/john' );
```

#### Feed Links

You can add one or more links to a channel. A link is an entity, with a corresponding class, [as per the spec](https://validator.w3.org/feed/docs/atom.html#link). As such you can call a number of methods on an instance of `Link` to set the `url`, `rel` attribute, `type`, the language of the referenced resource (`hreflang`), the `title` or the `length`.

You should add a link back to the feed itself:

```php
$feed
	->addLink( )
		->url( '/feed' )
		->rel( 'self' );
```		

Or use the short-cut method:

```php
$feed->addLinkToSelf( 'http://example.org/feed' )
```
		
To add a link to a related webpage, you might do this:

```php
$feed
	->addLink( )
		->url( 'http://www.example.com' )
		->rel( 'alternate' );
```		

### Optional Feed Elements

There are a number of additional elements [defined by the spec](https://validator.w3.org/feed/docs/atom.html#optionalFeedElements).

#### The Feed's Categor(ies)

A feed can have one or more categories.

Like `Person` and `Link`, a `Category` is also an object; refer to the relevant section [in the spec](https://validator.w3.org/feed/docs/atom.html#category). Thus, calling `addCategory()` will return an object; you can then call methods on that to set various properties.

Here's the method at its simplest:

```php
$feed->addCategory( )
	->term( 'example' );
```

A category may also have a `scheme` and/or a `label`:

```php
$feed->addCategory( )
	->term( 'example' )
	->scheme( 'http://example.com/categories/')
	->label( 'An example' );	
```

#### Contributor(s) to a Feed

In addition to authors, you may also specify contributors. Like `addAuthor()`, this is modelled by the `Person` class.

To illustrate with an example:

```php
$feed->addContributor( )
	->name( 'Jane Doe' )
	->email( 'jane@doe.com' )
	->uri( 'http://doe.com/jane' );
```

#### The Generator	

The generator is the software used to generate the feed, and in addition to a name may specify a related URI and / or a version number.

Just the name:

```php
$feed->generator( 'PHP Feed Writer' );
```            

Including a URI and version:

```php
$feed->generator(
	'PHP Feed Writer',
	'https://github.com/lukaswhite/php-feed-writer',
	'1.0' 
);
```            

If you find this package useful, please consider setting it!

#### Icon

To associate an icon with a feed:

```php
$feed->icon( 'http://example.org/icon.png' );
```

> Icons should be square

#### Feed Image

The image "identifies a larger image which provides visual identification for the feed.".

```php
$feed->image( 'http://example.org/image.png' );
```

> Images should be twice as wide as they are tall.

#### Rights

Rights just means a copyright notice. It may contain HTML, provided you indicate that when setting it.

Plain text:

```php
$feed->rights( 'Copyright 2018 Example' );
```

With HTML:

```php
$feed->rights( '&amp;copy; 2005 John Doe', 'html' );
```

#### Subtitle

You can also add a subtitle to a feed:

```php
$feed->subtitle( 'Just an example' );
```

Like the `title()` method takes an optional second argument that specifies the type, so be sure to set it to `html` should your subtitle contain HTML.

### Atom Feed Entries

Once you've created your Atom feed and set the relevant information, it's time to start adding entries.

A number of the methods on the `Entry` class are the same as feeds, as are the concepts of the various entites; for example `Person`, `Category` and `Link`. Like feeds, a number of the text-based elements can also have an associated type including, but not limited to, `plain` (the default) and `html`.

To add an entry:

```php
$entry = $feed->addEntry( );
```

This returns an instance of the `Entry` class, many of whose methods adopt a fluent interface.

### Required Entry Elements

An entry has three required elements; the `title`, `id` and `updated`.

#### Setting an Entry's Title

To set the title of an entry:

```php
$entry->title( 'Atom-Powered Robots Run Amok' );
```

If your title contains HTML:

```php
$entry->title( 'Atom-Powered Robots <strong>Run Amok</strong>', 'html' );
```

#### Specifying the ID of an Entry

The `id` element uniquely identifies an Atom feed's entry. It's usually the URI that represents the entry, but you can use whatever you like; for example, you can use a URN ([Uniform Resource Name](https://en.wikipedia.org/wiki/Uniform_Resource_Name)).

```php
$entry->id( 'urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a' );
```

#### Setting the `updated` Element

The third and final required element on an Atom Entry is `updated`, which indicates the last time the entry was modified in a significant way. 

From the spec; "this value need not change after a typo is fixed, only after a substantial modification. Generally, different entries in a feed will have different updated timestamps."

To set it, simply pass an instance of `DateTime` to the `updated()` method:

```php
$entry->updated( new \DateTime( '2003-12-13T18:30:02Z' ) )
```

### Recommended Entry Elements

There are anumber of elements that the spec [recommends](https://validator.w3.org/feed/docs/atom.html#recommendedEntryElements) that you incorporate into your entries.

#### Authors

You can specify one or more authors of an entry in exactly the same way as for feeds.

```php
$entry->addAuthor( )
	->name( 'John Doe' )
	->email( 'john@doe.com' )
	->uri( 'http://doe.com/john' );
```

#### Content

An Atom feed entry may contain the actual content of an item. Note that if you don't provide a link then you must set the content.

```php
$entry->content( 'The content of the entry' );
```

You can use HTML:

```php
$entry->content( 'The content of the <strong>entry</strong>', 'html' );
```

You'll find more information about content [here](https://validator.w3.org/feed/docs/atom.html#contentElement).

#### Links

Generally a link in an entry represents a related web page. Like feeds, links are modelled using the `Link` class, which in turn represents the `Link` construct [defined in the spec](https://validator.w3.org/feed/docs/atom.html#link).

Here's a simple example:

```php
$entry
	->addLink( )
	->url( 'http://example.org/2003/12/13/atom03' );
```

You may also use the `rel()`, `type()` and `language()` methods if you wish.

#### Entry Summary

You can also provide a short summary, abstract, or excerpt of the entry using the `summary()` method.

```php
$entry->summary( 'Short summary here' );
```

Again, the method has an optional second parameter that specifies the type, for example:

```php
$entry->summary( 'Short <strong>summary</strong> here' );
```

### Optional Entry Elements

There are a few other elements you can add to an entry that are optional.

#### Categories

Categories work in exactly the same way as feeds, so in other words in addition to the term itself they may have a `term`, `scheme` and / or a `label`.

At its simplest:

```php
$entry->addCategory( )
	->term( 'example' );
```

Adding additional information about the category:

```php
$entry->addCategory( )
	->term( 'example' )
	->scheme( 'http://example.com/categories/')
	->label( 'An example' );
```

#### The Publication Date

The `published` element represents the date and time an entry was initially created.

Set it in the same way as the `updated` element; i.e. with an instance of `DateTime`.

```php
$entry->published( new \DateTime( '2003-12-11T18:30:02Z' ) );
```

#### Rights

Rights refers to the copyright notice, and works in exactly the same way as the feed.

Plain text:

```php
$entry->rights( 'Copyright 2018 Example' );
```

With HTML:

```php
$entry->rights( '&amp;copy; 2005 John Doe', 'html' );
```

#### Source

If an entry is a copy then the `source` element provides metadata about the original.

To add a source:

```php
$entry->addSource( )
	->id( 'http://example.org/' )
	->title( 'Example, Inc.' )
	->updated( new \DateTime( '2003-12-13T18:30:02Z' ) );
```

### Adding Enclosures to Atom Entries

To add an enclosure to an Atom entry:

```php
$entry->addEnclosure( )
	->url( 'http://example.com/audio.mp3' )
	->length( 1000 )
	->type( 'audio/mpeg' );
```

Unlike RSS, where enclosures are presented by elements, in Atom an enclosure is actually a `<link>` that points to the fie in question, but with the `rel` attribute set to `enclosure`.	
		
### Feed Namespaces

Namespaces work in exactly the same way as RSS, except that the default namespace for an Atom feed is set to `http://www.w3.org/2005/Atom`.


## MediaRSS

[MediaRSS](http://www.rssboard.org/media-rss) is an extension of the RSS specification which allows you to incoporate media &mdash; such as images, videos and audio &mdash; in your RSS feeds. It's much more comprehensive than the image and enclosures provided by RSS.

You can add the following media types:

- Images
- Videos
- Audio
- Documents
- Executables

In addition to providing references to the media itself, you can provide all sorts of additional information, such as:

- Thumbnails
- Transcripts of videos
- Restrictions
- Comments
- Credits

### Bare-bones Example

In the following example, we're adding a video to an RSS item:

```php
$media = $item->addMedia( )
	->url( 'http://www.webmonkey.com/monkeyrock.mpg' )
	->medium( Media::VIDEO )
	->fileSize( 2471632 )
	->type( 'video/mpeg' );
);
```

### A More Comprehensive Example

In this example, we're adding a whole raft of additional information about a video:

```php
$media = $item->addMedia( )
	->url( 'http://www.webmonkey.com/monkeyrock.mpg' )
	->fileSize( 2471632 )
	->type( 'video/mpeg' )
	->title( 'The Webmonkey Band "Monkey Rock"' )
	->description( 'See Rocking Webmonkey Garage Band playing our classic song "Monkey Rock" to a sold-out audience at the <a href="http://www.fillmoreauditorium.org/">Fillmore Auditorium</a>.', 'html' )
	->keywords( 'monkeys', 'music', 'rock' )
	->width( 320 )
	->height( 240 )
	->duration( 147 )
	->medium( Media::VIDEO )
	->expression( Media::FULL )
	->bitrate( 128 )
	->framerate( 24 )
	->isDefault( )
	->player( 'http://www.somevideouploadsite/webmonkey.html' )
	->hash( 'dfdec888b72151965a34b4b59031290a', 'md5' )
	->comments(
		'This is great',
		'I like this'
);
```

## GeoRSS

The library also supports [GeoRSS Simple](http://www.georss.org/simple.html), which is an extension of RSS &mdash; and, despite what the name suggests &mdash; Atom. It allows you to associate geographical locations with an RSS channel or item, or an Atom feed or entry.

To use it, call `geoRSS()` on the channel / item / feed / entry, then call a method on the instance of the class it returns. That's probably better explained with an example:

```php
$entry->geoRSS( )->addPoint( 45.256, -71.92 );
```

What we're doing here is associating the point represented by a lat/lng pair.

Alternatively you can associate an entity with a line, polygon or (bounding) box:

```php
$entry->geoRSS( )->addLine( '45.256 -110.45 46.46 -109.48 43.84 -109.86' );
// or
$entry->geoRSS( )->addPolygon( '45.256 -110.45 46.46 -109.48 43.84 -109.86 45.256 -110.45' );
// or
$entry->geoRSS( )->addBox( '42.943 -71.032 43.039 -69.856' );
```

You can also specify the type of feature &mdash; for example, a city &mdash; like this:

```php
$entry->geoRSS( )->featureType( 'city' );
```

You can also name the feature in question:

```php
$entry->geoRSS( )->featureName( 'Manchester' );
```

To define the relationship to the feature or location:

```php
$entry->geoRSS( )->relationshipTag( 'is-centered-on' );
```

There's also this short-cut:

```php
$entry->geoRSS( )->isCenteredOnPoint( 45.256, -71.92 );
```

To define the radius:

```php
$entry->geoRSS( )->radius( 500 );
```

Finally, you can also specify the elevation and / or floor:

```php
$entry->geoRSS( )->elevation( 313 );
```

```php
$entry->geoRSS( )->floor( 2 );
```

Whenever you call any of these methods, the GeoRSS namespace is automatically added for you.

## Extending the Library

The library ought to be pretty simple to extend. It provides many of the "building blocks" you would need to do so.

If you plan to extend it, here are some pointers that may help.

Internally, the feed is built using PHP's `DomDocument` class.

Everything &mdash; e.g. channels, items, entries, images, enclosures &mdash; is an entity, which is essentially:

- A bunch of properties
- (Fluent) setters
- A method named `element()` which converts the entity into a `DOMElement`

To create your own entities, simply extend the `Entity` class, and implement the abstract `element()` method.

The library makes extensive use of traits; for example there's a trait for titles, one for media, for dimensions and so on. Generally traits provide the properties, the setters and a method to append the appropriate information to a DOM element, that you need to call in your `element()` implementation.

Here's a really simple example:

```php
/**
 * Trait HasTitle
 *
 * @package Lukaswhite\FeedWriter\Traits
 */
trait HasTitle
{
    /**
     * The title
     *
     * @var string
     */
    protected $title;

    /**
     * Set the title
     *
     * @param string $title
     * @return $this
     */
    public function title( string $title ) : self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Add the title to the specified element.
     *
     * @param \DOMElement $el
     * @return void
     */
    protected function addTitleElement( \DOMElement $el ) : void
    {
        if ( $this->title ) {
            $el->appendChild( $this->createElement( 'title', $this->title ) );
        }
    }
}
```

If you have a look at the `Item` class, for example, you'll see that it utilizes this trait.

Here's an abbreviated version of the `Item` class' `element()` method:

```php
<?php

namespace Lukaswhite\FeedWriter\Entities\Rss;

/**
 * Class Item
 *
 * @package Lukaswhite\FeedWriter\Entities\Rss
 */
class Item extends Entity
{
    
    /**
     * Create a DOM element that represents this entity.
     *
     * @return \DOMElement
     */
    public function element( ) : \DOMElement
    {
        $item = $this->feed->getDocument( )->createElement( 'item' );

        $this->addTitleElement( $item );
        $this->addDescriptionElement( $item );
        
        // ...rest of method

        return $item;
    }
}
```

Hopefully that's enough for you to get started, should you need to extend it.

## References

- [A Guide to Atom](https://validator.w3.org/feed/docs/atom.html)
- The [MediaRSS](http://www.rssboard.org/media-rss) specification
- [Podcast RSS iTunes](https://github.com/simplepie/simplepie-ng/wiki/Spec:-iTunes-Podcast-RSS) specification
- The [GeoRSS Simple](http://www.georss.org/simple.html) specification

> End of documentation for now; it's a work-in-progress.