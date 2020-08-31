<?php

namespace Tests\Feature\Model;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

class CatergoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Category
     */
    private $category;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->category = new Category();
    }

    public function testList()
    {
        factory(Category::class, 10)->create();
        $categories = $this->category->all();
        self::assertCount(10, $categories);
        $expected_category_keys = ['id', 'name', 'description', 'is_active', 'created_at', 'updated_at', 'deleted_at'];
        $category_keys = array_keys($categories->first()->getAttributes());
        self::assertEqualsCanonicalizing($expected_category_keys, $category_keys);
    }

    public function testCreate()
    {
        $cat = $this->category->create(['name' => 'Teste 1']);
        self::assertEquals('Teste 1', $cat->name);
        $cat->refresh();
        self::assertEquals('Teste 1', $cat->name);
        $isUUID = preg_match('/[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $cat->id);
        self::assertEquals(1, $isUUID);
        self::assertNull($cat->description);
        self::assertTrue($cat->is_active);
        $cat_1 = $this->category->create(['name' => 'Teste 2', 'description' => 'desc1']);
        $cat_1->refresh();
        self::assertEquals('Teste 2', $cat_1->name);
        self::assertEquals('desc1', $cat_1->description);
        self::assertTrue($cat_1->is_active);
        $cat_2 = $this->category->create(['name' => 'Teste 3', 'description' => 'desc2', 'is_active' => true]);
        $cat_2->refresh();
        self::assertEquals('Teste 3', $cat_2->name);
        self::assertEquals('desc2', $cat_2->description);
        self::assertTrue($cat_2->is_active);
        $cat_3 = $this->category->create(['name' => 'Teste 4', 'description' => 'desc3', 'is_active' => false]);
        $cat_3->refresh();
        self::assertEquals('Teste 4', $cat_3->name);
        self::assertEquals('desc3', $cat_3->description);
        self::assertFalse($cat_3->is_active);
        $cat_4 = $this->category->create(['name' => 'Teste 5', 'description' => null, 'is_active' => false]);
        $cat_4->refresh();
        self::assertEquals('Teste 5', $cat_4->name);
        self::assertNull($cat_4->description);
        self::assertFalse($cat_4->is_active);
        $cat_5 = $this->category->create(['name' => 'Teste 6', 'description' => '', 'is_active' => false]);
        $cat_5->refresh();
        self::assertEquals('Teste 6', $cat_5->name);
        //@todo make sure empty strig return null
        self::assertEquals('', $cat_5->description);
        self::assertFalse($cat_5->is_active);
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create();
        $category->update(['name' => 'Teste 1', 'description' => 'desc3', 'is_active' => false]);
        self::assertEquals('Teste 1', $category->name);
        self::assertEquals('desc3', $category->description);
        self::assertFalse($category->is_active);
        $category_1 = factory(Category::class)->create();
        $category_1->update(['description' => 'desc3']);
        self::assertEquals('desc3', $category_1->description);
        $category_2 = factory(Category::class)->create();
        $category_2->update(['is_active' => false]);
        self::assertFalse($category_2->is_active);
        $category_3 = factory(Category::class)->create();
        $category_3->update(['name' => 'Teste 3']);
        self::assertEquals('Teste 3', $category_3->name);
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create();
        self::assertCount(1, $this->category->all());
        self::assertTrue($category->delete());
        self::assertCount(0, $this->category->all());
        self::assertCount(1, $this->category->withTrashed()->get());
    }

    public function testFindFail()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->category->findOrFail(Str::uuid());
        $this->category->find(Str::uuid());
    }
    public function testFind()
    {
        $uuid = Str::uuid();
        $category = $this->category->find($uuid);
        self::assertNull($category);
        factory(Category::class)->create(['id' => $uuid, 'name' => 'Teste 1']);
        $category = $this->category->find($uuid);
        self::assertInstanceOf(Category::class, $category);
    }
}