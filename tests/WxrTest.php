<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Entities\Media\Media;
use Lukaswhite\FeedWriter\Entities\Rss\Item;
use Lukaswhite\FeedWriter\Entities\Wxr\Author;
use Lukaswhite\FeedWriter\Entities\Wxr\Channel;
use Lukaswhite\FeedWriter\Entities\Wxr\Post;
use Lukaswhite\FeedWriter\RSS2;
use Lukaswhite\RSSWriter\Feed;

class WxrTest extends TestCase
{
    public function testCreatingFeed()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $post = $channel->addPost();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertInstanceOf(Item::class, $post);

        $post
            ->title('Foo Bar')
            ->link('http://foo.com/example')
            ->date(new \DateTime('2010-09-20 09:13:44'), true)
            ->disqusThreadIdentifier('disqus_identifier')
            ->commentStatus('open');

        /**
         * $post->addCategory( )
         * ->term( 'Uncategorized' )
         * ->domain( 'category' );**/

        $comment = $post->addComment();

        $comment
            ->id(65)
            ->isOpen()
            ->date(new \DateTime('2010-09-20 13:19:10'), true)
            ->author('Foo Bar')
            ->authorEmail('foo@bar.com')
            ->authorUrl('http://www.foo.bar/')
            ->authorIp('93.48.67.119')
            ->content('Hello world!');

        $remote = $comment->addRemote();

        $remote
            ->id('user id')
            ->avatar('http://url.to/avatar.png');

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);
        $channels = $xpath->query('/rss/channel');
        $this->assertEquals(1, $channels->length);

        $items = $xpath->query('/rss/channel/item');
        $this->assertEquals(1, $items->length);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:post_date')->length);
        $this->assertEquals(
            '2010-09-20 09:13:44',
            $xpath->query('/rss/channel/item/wp:post_date')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:post_date_gmt')->length);
        $this->assertEquals(
            '2010-09-20 09:13:44',
            $xpath->query('/rss/channel/item/wp:post_date_gmt')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/dsq:thread_identifier')->length);
        $this->assertEquals(
            'disqus_identifier',
            $xpath->query('/rss/channel/item/dsq:thread_identifier')[0]->textContent
        );

        $comments = $xpath->query('/rss/channel/item/wp:comment');
        $this->assertEquals(1, $comments->length);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_id')->length);
        $this->assertEquals(
            65,
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_id')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_status')->length);
        $this->assertEquals(
            'open',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_status')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_date')->length);
        $this->assertEquals(
            '2010-09-20 13:19:10',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_date')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_date_gmt')->length);
        $this->assertEquals(
            '2010-09-20 13:19:10',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_date_gmt')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_author')->length);
        $this->assertEquals(
            'Foo Bar',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_author')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_author_email')->length);
        $this->assertEquals(
            'foo@bar.com',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_author_email')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_author_url')->length);
        $this->assertEquals(
            'http://www.foo.bar/',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_author_url')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_author_IP')->length);
        $this->assertEquals(
            '93.48.67.119',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_author_IP')[0]->textContent
        );


        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/dsq:remote')->length);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/dsq:remote/dsq:id')->length);
        $this->assertEquals(
            'user id',
            $xpath->query('/rss/channel/item/wp:comment/dsq:remote/dsq:id')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/dsq:remote/dsq:avatar')->length);
        $this->assertEquals(
            'http://url.to/avatar.png',
            $xpath->query('/rss/channel/item/wp:comment/dsq:remote/dsq:avatar')[0]->textContent
        );

    }

    public function testCreatingFeedWithGmtDatesDifferent()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $post = $channel->addPost();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertInstanceOf(Item::class, $post);

        $post
            ->title('Foo Bar')
            ->link('http://foo.com/example')
            ->date(new \DateTime('2010-09-20 09:13:44'))
            ->dateGmt(new \DateTime('2010-09-20 08:13:44'));

        $comment = $post->addComment();

        $comment
            ->id(65)
            ->isOpen()
            ->date(new \DateTime('2010-09-20 13:19:10'), true)
            ->dateGmt(new \DateTime('2010-09-20 12:19:10'), true)
            ->author('Foo Bar')
            ->authorEmail('foo@bar.com')
            ->authorUrl('http://www.foo.bar/')
            ->authorIp('93.48.67.119')
            ->content('Hello world!');

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:post_date')->length);
        $this->assertEquals(
            '2010-09-20 09:13:44',
            $xpath->query('/rss/channel/item/wp:post_date')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:post_date_gmt')->length);
        $this->assertEquals(
            '2010-09-20 08:13:44',
            $xpath->query('/rss/channel/item/wp:post_date_gmt')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_date')->length);
        $this->assertEquals(
            '2010-09-20 13:19:10',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_date')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_date_gmt')->length);
        $this->assertEquals(
            '2010-09-20 12:19:10',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_date_gmt')[0]->textContent
        );


    }

    public function testCreatingFeedWithMetadataAndCategorization()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $channel
            ->title('Data Portability Testbed')
            ->link('http://jlueck.wordpress.com')
            ->description('Just another WordPress.com weblog')
            ->pubDate(new \DateTime('2008-05-16 22:46:22'))
            ->generator('http://wordpress.org/?v=MU')
            ->language('en');

        $channel
            ->baseSiteUrl('http://wordpress.com/')
            ->baseBlogUrl('http://jlueck.wordpress.com');

        /**
         * $channel
         * ->addCategory( )**/

        $channel
            ->addTag()
            ->name('dunkin donuts')
            ->slug('dunkin-donuts')
            ->description('Dunkin Donuts');

        $channel
            ->addTag()
            ->name('dunkin donuts first')
            ->slug('dunkin-donuts-first');

        $channel
            ->addTag()
            ->name('NewTag')
            ->slug('newtag');

        $channel
            ->addCategory()
            ->name('DataPortability')
            ->niceName('dataportability');

        $channel
            ->addCategory()
            ->name('Uncategorized')
            ->niceName('uncategorized');

        $channel
            ->addCategory()
            ->name('upload')
            ->niceName('upload');

        $channel
            ->addCategory()
            ->name('wordpress2blogger')
            ->niceName('wordpress2blogger');

        $item1 = $channel
            ->addPost()
            ->title('About')
            ->link('http://jlueck.wordpress.com/about/')
            ->pubDate(new \DateTime('2008-01-11 20:23:05'))
            ->dcCreator('jlueck')
            ->encodedContent('This is an example of a WordPress page, you could edit this to put information about yourself or your site so readers know where you are coming from. You can create as many pages like this one or sub-pages as you like and manage all of your content inside of WordPress.')
            ->id(2)
            ->date(new \DateTime('2008-01-11 20:23:05'), true)
            ->commentsAreOpen()
            ->openForPings()
            ->isPublished();

        $item2 = $channel
            ->addPost()
            ->title('A test of newlines and labels/categories')
            ->link('http://jlueck.wordpress.com/2008/05/16/a-test-of-newlines-and-labelscategories/')
            ->pubDate(new \DateTime('2008-05-16 19:40:23'))
            ->dcCreator('jlueck')
            ->guid('http://jlueck.wordpress.com/?p=17', false)
            ->encodedContent('We\'re having fun with tags, labels, and categories today on the Data Portability Testbed blog.')
            ->id(17)
            ->date(new \DateTime('2008-05-16 19:40:23'))
            ->dateGmt(new \DateTime('2008-05-16 19:40:23'))
            ->commentStatus(Post::COMMENTS_OPEN)
            ->pingStatus(Post::PINGS_OPEN)
            ->status(Post::PUBLISHED);

        $item2
            ->addPostMeta()
            ->key('_edit_lock')
            ->value(1210966825);

        $item2
            ->addPostMeta()
            ->key('_edit_last')
            ->value(2575641);

        $item2
            ->addComment()
            ->id(8)
            ->author('jlueck')
            ->authorEmail('jlueck@gmail.com')
            ->authorIp('72.14.229.1')
            ->date(new \DateTime('2008-05-16 20:24:37'), true)
            ->content('Now let\'s try to see what it takes to make a comment work correctly.

Can you see this?')
            ->userId(2575641);

        /**
         * <wp:comment_approved>1</wp:comment_approved>
         * <wp:comment_type></wp:comment_type>
         * <wp:comment_parent>0</wp:comment_parent>
         * <wp:comment_user_id>2575641</wp:comment_user_id>
         * </wp:comment>**/

        /**
         *
         * <wp:post_id>17</wp:post_id>
         * <wp:post_date>2008-05-16 19:40:23</wp:post_date>
         * <wp:post_date_gmt>2008-05-16 19:40:23</wp:post_date_gmt>
         * <wp:comment_status>open</wp:comment_status>
         * <wp:ping_status>open</wp:ping_status>
         * <wp:post_name>a-test-of-newlines-and-labelscategories</wp:post_name>
         * <wp:status>publish</wp:status>
         * <wp:post_parent>0</wp:post_parent>
         * <wp:menu_order>0</wp:menu_order>
         * <wp:post_type>post</wp:post_type>
         * <wp:post_password></wp:post_password>**/

        /**
         * <category><![CDATA[DataPortability]]></category>
         *
         * <category domain="category" nicename="dataportability"><![CDATA[DataPortability]]></category>
         *
         * <category><![CDATA[wordpress2blogger]]></category>
         *
         * <category domain="category" nicename="wordpress2blogger"><![CDATA[wordpress2blogger]]></category>
         *
         * <category domain="tag"><![CDATA[NewTag]]></category>
         *
         * <category domain="tag" nicename="newtag"><![CDATA[NewTag]]></category>**/

        /**
         * <wp:comment_status>open</wp:comment_status>
         * <wp:ping_status>open</wp:ping_status>
         * <wp:post_name>about</wp:post_name>
         * <wp:status>publish</wp:status>
         * <wp:post_parent>0</wp:post_parent>
         * <wp:menu_order>0</wp:menu_order>
         * <wp:post_type>page</wp:post_type>
         * <wp:post_password></wp:post_password>
         * </item>**/


        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(3, $xpath->query('/rss/channel/wp:tag')->length);

        $this->assertEquals(
            'dunkin donuts',
            $xpath->query('/rss/channel/wp:tag/wp:tag_name')[0]->textContent
        );
        $this->assertEquals(
            'dunkin-donuts',
            $xpath->query('/rss/channel/wp:tag/wp:tag_slug')[0]->textContent
        );
        $this->assertEquals(
            'Dunkin Donuts',
            $xpath->query('/rss/channel/wp:tag/wp:tag_description')[0]->textContent
        );
        $this->assertEquals(
            'dunkin donuts first',
            $xpath->query('/rss/channel/wp:tag/wp:tag_name')[1]->textContent
        );
        $this->assertEquals(
            'dunkin-donuts-first',
            $xpath->query('/rss/channel/wp:tag/wp:tag_slug')[1]->textContent
        );
        $this->assertEquals(
            'NewTag',
            $xpath->query('/rss/channel/wp:tag/wp:tag_name')[2]->textContent
        );
        $this->assertEquals(
            'newtag',
            $xpath->query('/rss/channel/wp:tag/wp:tag_slug')[2]->textContent
        );

        $this->assertEquals(4, $xpath->query('/rss/channel/wp:category')->length);

        $this->assertEquals(
            'DataPortability',
            $xpath->query('/rss/channel/wp:category/wp:cat_name')[0]->textContent
        );
        $this->assertEquals(
            'dataportability',
            $xpath->query('/rss/channel/wp:category/wp:category_nicename')[0]->textContent
        );

        $comment = $item1->addComment();
        $comment->isOpen();
    }

    public function testCommentStatusOpen()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $channel = $feed->addChannel();
        $item = $channel->addItem();
        $comment = $item->addComment();
        $comment->isOpen();

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment')->length);
        $this->assertEquals(
            'open',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_status')[0]->textContent
        );
    }

    public function testCommentStatusClosed()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $channel = $feed->addChannel();
        $item = $channel->addItem();
        $comment = $item->addComment();
        $comment->isClosed();

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment')->length);
        $this->assertEquals(
            'closed',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_status')[0]->textContent
        );
    }

    public function testCommentApproved()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $channel = $feed->addChannel();
        $item = $channel->addItem();
        $comment = $item->addComment();
        $comment->hasBeenApproved();

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_approved')->length);
        $this->assertEquals(
            1,
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_approved')[0]->textContent
        );
    }

    public function testCommentNotApproved()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $channel = $feed->addChannel();
        $item = $channel->addItem();
        $comment = $item->addComment();
        $comment->hasNotBeenApproved();

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_approved')->length);
        $this->assertEquals(
            '',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_approved')[0]->textContent
        );
    }

    public function testCommentTypes()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $channel = $feed->addChannel();
        $item = $channel->addItem();

        $comment1 = $item->addComment();
        $comment1->isComment();

        $comment2 = $item->addComment();
        $comment2->isTrackback();

        $comment3 = $item->addComment();
        $comment3->isPingback();

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(3, $xpath->query('/rss/channel/item/wp:comment/wp:comment_type')->length);
        $this->assertEquals(
            'comment',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_type')[0]->textContent
        );
        $this->assertEquals(
            'trackback',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_type')[1]->textContent
        );
        $this->assertEquals(
            'pingback',
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_type')[2]->textContent
        );
    }

    public function testCommentWithParent()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $channel = $feed->addChannel();
        $item = $channel->addItem();

        $comment1 = $item->addComment();
        $comment1->id(123);

        $comment2 = $item->addComment();
        $comment2->parent($comment1);

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:comment/wp:comment_parent')->length);
        $this->assertEquals(
            123,
            $xpath->query('/rss/channel/item/wp:comment/wp:comment_parent')[0]->textContent
        );
    }

    public function testMiscellaneousChannelProperties()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $channel->baseSiteUrl('https://example.com')
            ->baseBlogUrl('https://example.com/blog');

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/wp:base_site_url')->length);
        $this->assertEquals(
            'https://example.com',
            $xpath->query('/rss/channel/wp:base_site_url')[0]->textContent
        );

        $this->assertEquals(1, $xpath->query('/rss/channel/wp:base_blog_url')->length);
        $this->assertEquals(
            'https://example.com/blog',
            $xpath->query('/rss/channel/wp:base_blog_url')[0]->textContent
        );
    }

    public function testAddingChannelAuthors()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $author1 = $channel->addAuthor();

        $this->assertInstanceOf(Author::class, $author1);

        $author1->id(1)
            ->login('john')
            ->email('john@example.com')
            ->firstName('John')
            ->lastName('Doe');

        $channel->addAuthor()->id(2)
            ->login('jane')
            ->email('jane@example.com')
            ->displayName('Jane Doe');

        $xml = $feed->build();
        $this->assertEquals('rss', $xml->documentElement->tagName);

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(2, $xpath->query('/rss/channel/wp:author')->length);

        $this->assertEquals(
            1,
            $xpath->query('/rss/channel/wp:author/wp:author_id')[0]->textContent
        );

        $this->assertEquals(
            'john',
            $xpath->query('/rss/channel/wp:author/wp:author_login')[0]->textContent
        );

        $this->assertEquals(
            'john@example.com',
            $xpath->query('/rss/channel/wp:author/wp:author_email')[0]->textContent
        );

        $this->assertEquals(
            1,
            $xpath->query('/rss/channel/wp:author/wp:author_id')[0]->textContent
        );

        $this->assertEquals(
            'John',
            $xpath->query('/rss/channel/wp:author/wp:author_first_name')[0]->textContent
        );

        $this->assertEquals(
            'Doe',
            $xpath->query('/rss/channel/wp:author/wp:author_last_name')[0]->textContent
        );

        $this->assertEquals(
            2,
            $xpath->query('/rss/channel/wp:author/wp:author_id')[1]->textContent
        );

        $this->assertEquals(
            'jane',
            $xpath->query('/rss/channel/wp:author/wp:author_login')[1]->textContent
        );

        $this->assertEquals(
            'jane@example.com',
            $xpath->query('/rss/channel/wp:author/wp:author_email')[1]->textContent
        );

        $this->assertEquals(
            'Jane Doe',
            $xpath->query('/rss/channel/wp:author/wp:author_display_name')[0]->textContent
        );
    }

    public function testSettingPostMeta()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $post = $channel->addPost();

        $post->addPostMeta()
            ->key('_edit_lock')
            ->value(1210966825);

        $post->addPostMeta()
            ->key('_edit_last')
            ->value(2575641);

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(2, $xpath->query('/rss/channel/item/wp:postmeta')->length);

        $this->assertEquals(
            '_edit_lock',
            $xpath->query('/rss/channel/item/wp:postmeta/wp:meta_key')[0]->textContent
        );

        $this->assertEquals(
            1210966825,
            $xpath->query('/rss/channel/item/wp:postmeta/wp:meta_value')[0]->textContent
        );

        $this->assertEquals(
            '_edit_last',
            $xpath->query('/rss/channel/item/wp:postmeta/wp:meta_key')[1]->textContent
        );

        $this->assertEquals(
            2575641,
            $xpath->query('/rss/channel/item/wp:postmeta/wp:meta_value')[1]->textContent
        );

    }

    public function testPostsClosedForCommentsAndPings()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $post = $channel->addPost();

        $post
            ->commentsAreClosed()
            ->closedForPings();

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(
            'closed',
            $xpath->query('/rss/channel/item/wp:comment_status')[0]->textContent
        );

        $this->assertEquals(
            'closed',
            $xpath->query('/rss/channel/item/wp:ping_status')[0]->textContent
        );

    }

    public function testSettingPostStatus()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $post1 = $channel->addPost();

        $post1
            ->isDraft();

        $post2 = $channel->addPost();

        $post2
            ->isFuture();

        $post3 = $channel->addPost();

        $post3
            ->isPrivate();

        $post4 = $channel->addPost();

        $post4
            ->isTrash();

        $post5 = $channel->addPost();

        $post5
            ->isAutoDraft();

        $post6 = $channel->addPost();

        $post6
            ->inheritStatus();

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(
            'draft',
            $xpath->query('/rss/channel/item/wp:status')[0]->textContent
        );

        $this->assertEquals(
            'future',
            $xpath->query('/rss/channel/item/wp:status')[1]->textContent
        );

        $this->assertEquals(
            'private',
            $xpath->query('/rss/channel/item/wp:status')[2]->textContent
        );

        $this->assertEquals(
            'trash',
            $xpath->query('/rss/channel/item/wp:status')[3]->textContent
        );

        $this->assertEquals(
            'auto_draft',
            $xpath->query('/rss/channel/item/wp:status')[4]->textContent
        );

        $this->assertEquals(
            'inherit',
            $xpath->query('/rss/channel/item/wp:status')[5]->textContent
        );


    }

    public function testPostAttachments()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $channel->addPost()
            ->type('attachment')
            ->addAttachmentUrl('http://jlueck.wordpress.com/files/2008/05/android_cardback.png');

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(
            'attachment',
            $xpath->query('/rss/channel/item/wp:post_type')[0]->textContent
        );

        $this->assertEquals(
            'http://jlueck.wordpress.com/files/2008/05/android_cardback.png',
            $xpath->query('/rss/channel/item/wp:attachment_url')[0]->textContent
        );
    }

    public function testPostTypes()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $channel->addPost()
            ->type('page');

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(
            'page',
            $xpath->query('/rss/channel/item/wp:post_type')[0]->textContent
        );
    }

    public function testMiscellaneousPostProperties()
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $channel->addPost( )
            ->menuOrder( 2 )
            ->password( 'secret' )
            ->author( 'Lukas White' );

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(
            2,
            $xpath->query('/rss/channel/item/wp:menu_order')[0]->textContent
        );

        $this->assertEquals(
            'secret',
            $xpath->query('/rss/channel/item/wp:post_password')[0]->textContent
        );
    }

    public function testPostParents( )
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $parent = $channel->addPost( )
            ->id( 123 )
            ->title( 'Parent post' );

        $channel->addPost( )
            ->id( 321 )
            ->title( 'Child post' )
            ->parent( $parent );

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/item/wp:post_parent')->length);

        $this->assertEquals(
            123,
            $xpath->query('/rss/channel/item/wp:post_parent')[0]->textContent
        );
    }

    public function testTerms( )
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $this->assertInstanceOf(Channel::class, $channel);

        $post = $channel->addPost( )
            ->id( 123 )
            ->title( 'Test Post' );

        $rockNRoll = $post->addTerm( )
            ->termId( 1 )
            ->taxonomy( 'musical-styles' )
            ->name( 'Rock and Roll' )
            ->description( 'Just rock n roll' )
            ->slug( 'rock-and-roll' );

        $rockNRoll->addTermMeta( )
            ->key( '_post_count' )
            ->value( 12 );

        $rockNRoll->addTermMeta( )
            ->key( '_created_by' )
            ->value( 'nigel' );

        $post->addTerm( )
            ->termId( 2 )
            ->taxonomy( 'musical-styles' )
            ->name( 'Blues' )
            ->description( 'Old time blues' )
            ->slug( 'blues' );

        $post->addTerm( )
            ->termId( 3 )
            ->taxonomy( 'musical-styles' )
            ->name( 'Classic Rock and Roll' )
            ->description( 'Classic rock n roll' )
            ->slug( 'classic-rock-and-roll' )
            ->parent( $rockNRoll );

        $xml = $feed->build();

        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(3, $xpath->query('/rss/channel/item/wp:term')->length);

        $this->assertEquals(
            1,
            $xpath->query('/rss/channel/item/wp:term/wp:term_id')[0]->textContent
        );

        $this->assertEquals(
            'musical-styles',
            $xpath->query('/rss/channel/item/wp:term/wp:term_taxonomy')[0]->textContent
        );

        $this->assertEquals(
            'Rock and Roll',
            $xpath->query('/rss/channel/item/wp:term/wp:term_name')[0]->textContent
        );

        $this->assertEquals(
            'Just rock n roll',
            $xpath->query('/rss/channel/item/wp:term/wp:term_description')[0]->textContent
        );

        $this->assertEquals(
            'rock-and-roll',
            $xpath->query('/rss/channel/item/wp:term/wp:term_slug')[0]->textContent
        );

        $this->assertEquals(2, $xpath->query('/rss/channel/item/wp:term/wp:termmeta')->length);

        $this->assertEquals(
            '_post_count',
            $xpath->query('/rss/channel/item/wp:term/wp:termmeta/wp:meta_key')[0]->textContent
        );

        $this->assertEquals(
            12,
            $xpath->query('/rss/channel/item/wp:term/wp:termmeta/wp:meta_value')[0]->textContent
        );

        $this->assertEquals(
            2,
            $xpath->query('/rss/channel/item/wp:term/wp:term_id')[1]->textContent
        );

        $this->assertEquals(
            'rock-and-roll',
            $xpath->query('/rss/channel/item/wp:term/wp:term_parent')[0]->textContent
        );
    }

    public function testSettingWxrVersion( )
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $feed->setWxrVersion( '1.2' );

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(1, $xpath->query('/rss/channel/wp:wxr_version')->length);

        $this->assertEquals(
            '1.2',
            $xpath->query('/rss/channel/wp:wxr_version')[0]->textContent
        );
    }

    public function testAdditionalCategoryProperties( )
    {
        $feed = new \Lukaswhite\FeedWriter\WXR();
        $feed->prettyPrint();

        $channel = $feed->addChannel();

        $post = $channel->addPost( )
            ->title( 'A post with categories' );

        $news = $post->addCategory( )
            ->name( 'News' )
            ->domain( 'categories' )
            ->slug( 'news' )
            ->description( 'News and current affairs' )
            ->niceName( 'news' );

        $politics = $post->addCategory( )
            ->name( 'Political News' )
            ->domain( 'categories' )
            ->niceName( 'poltical-news' )
            ->parent( $news );

        $xml = $feed->build();
        $doc = new \DOMDocument();
        $doc->loadXML($feed->toString());
        $xpath = new \DOMXPath($doc);

        $this->assertEquals(2, $xpath->query('/rss/channel/item/wp:category')->length);

        $this->assertEquals(
            'News',
            $xpath->query('/rss/channel/item/wp:category/wp:cat_name')[0]->textContent
        );

        $this->assertEquals(
            'News and current affairs',
            $xpath->query('/rss/channel/item/wp:category/wp:category_description')[0]->textContent
        );

        $this->assertEquals(
            'news',
            $xpath->query('/rss/channel/item/wp:category/wp:category_parent')[0]->textContent
        );
    }
}