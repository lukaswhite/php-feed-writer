<?php

namespace Lukaswhite\FeedWriter\Tests;

use Lukaswhite\FeedWriter\Data\Itunes\Categories;

class ItunesCategoriesTest extends TestCase
{
    public function testCanGetAllCategories()
    {
        $categories = new Categories();
        $this->assertTrue(is_array($categories->all()));
        $this->assertArrayHasKey('Kids &amp; Family', $categories->all());
        $this->assertTrue(is_array($categories->all()['Kids &amp; Family']));
        $this->assertTrue(is_array($categories->all()['Kids &amp; Family']));
        $this->assertArrayHasKey('children', $categories->all()['Kids &amp; Family']);
        $this->assertTrue(is_array($categories->all()['Kids &amp; Family']['children']));
        $this->assertArrayHasKey('Pets &amp; Animals', $categories->all()['Kids &amp; Family']['children']);
    }

    public function test_can_get_categories()
    {
        $categories = new Categories();
        $kids = $categories->get('Kids &amp; Family');
        $this->assertTrue(is_array($kids));
        $this->assertArrayHasKey('children', $kids);
        $this->assertTrue(is_array($kids['children']));
        $this->assertArrayHasKey('Pets &amp; Animals', $kids['children']);
    }

    public function test_can_get_subcategories()
    {
        $categories = new Categories();
        $pets = $categories->get('Kids &amp; Family', 'Pets &amp; Animals');
        $this->assertTrue(is_array($pets));
        $this->assertArrayHasKey('label', $pets);
    }

    public function test_get_returns_false_for_invalid_categories()
    {
        $categories = new Categories();
        $this->assertFalse($categories->get('Witchcraft'));
    }

    public function test_get_returns_false_for_invalid_sub_categories()
    {
        $categories = new Categories();
        $this->assertFalse($categories->get('Sports', 'Quidditch'));
    }

    public function test_get_returns_false_for_invalid_categories_and_sub_categories()
    {
        $categories = new Categories();
        $this->assertFalse($categories->get('Countries', 'Estonia'));
    }

    public function test_can_check_categories_exist()
    {
        $categories = new Categories();
        $this->assertTrue($categories->has('Sports' ));
        $this->assertTrue($categories->has('Sports', 'Football'));
        $this->assertFalse($categories->has('Witchcraft' ));
        $this->assertFalse($categories->has('Sports', 'Quidditch'));
    }

    public function test_can_get_category_children()
    {
        $categories = new Categories();
        $children = $categories->getChildren('Business');
        $this->assertTrue(is_array($children));
        $this->assertEquals(6,count($children));
        $this->assertArrayHasKey('Careers', $children);
    }

    public function test_can_get_check_if_category_has_children()
    {
        $categories = new Categories();
        $this->assertTrue($categories->hasChildren('Business'));
        $this->assertFalse($categories->hasChildren('Government'));
    }

    public function test_can_serialize_to_json()
    {
        $categories = new Categories();
        $this->assertEquals($categories->all(),json_decode(json_encode($categories),true));
    }

}