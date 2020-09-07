<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @group controller
 * @group category
 */
class CategoryController extends TestCase
{
    use DatabaseMigrations;
    /**
     * A test Category List.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->getJson(route('api.v1.categories.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
        $response->assertJsonFragment(['success' => true]);
        $categories= factory(Category::class, 10)->create(['is_active' => false]);
        $categoriesResource = CategoryResource::collection($categories);
        $response = $this->getJson(route('api.v1.categories.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonFragment(['success' => true]);
        $response->assertJsonFragment(['data' => $categoriesResource->resolve()]);
        $expected_category_keys = ['id', 'name', 'description', 'is_active', 'created_at', 'updated_at'];
        $category_keys = array_keys($response->json('data')[0]);
        self::assertEqualsCanonicalizing($expected_category_keys, $category_keys);
    }

    public function testCreate(): void
    {
        $response = $this->postJson(route('api.v1.categories.store'), ['name' => 'Teste 1']);
        self::assertEquals('Teste 1', $response->json('data.name'));
        $uuid = $response->json("data.id");
        $isUUID = preg_match('/[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid);
        self::assertEquals(1, $isUUID);
        self::assertNull($response->json("data.description"));
        self::assertTrue($response->json("data.is_active"));
        $response = $this->postJson(route('api.v1.categories.store'), ['name' => 'Teste 2', 'description' => 'desc1']);
        self::assertEquals('Teste 2', $response->json("data.name"));
        self::assertEquals('desc1', $response->json("data.description"));
        self::assertTrue($response->json("data.is_active"));
        $response = $this->postJson(
            route('api.v1.categories.store'),
            ['name' => 'Teste 3', 'description' => 'desc2', 'is_active' => true]
        );
        self::assertEquals(
            'Teste 3',
            $response->json("data.name")
        );
        self::assertEquals(
            'desc2',
            $response->json("data.description")
        );
        self::assertTrue($response->json("data.is_active"));
        $response = $this->postJson(
            route('api.v1.categories.store'),
            ['name' => 'Teste 4', 'description' => 'desc3', 'is_active' => false]
        );
        self::assertEquals('Teste 4', $response->json("data.name"));
        self::assertEquals(
            'desc3',
            $response->json("data.description")
        );
        self::assertFalse($response->json("data.is_active"));
        $response = $this->postJson(
            route('api.v1.categories.store'),
            ['name' => 'Teste 5', 'description' => null, 'is_active' => false]
        );
        self::assertEquals('Teste 5', $response->json("data.name"));
        self::assertNull($response->json("data.description"));
        self::assertFalse($response->json("data.is_active"));
        $response = $this->postJson(
            route('api.v1.categories.store'),
            ['name' => 'Teste 6', 'description' => '', 'is_active' => false]
        );
        self::assertEquals('Teste 6', $response->json("data.name"));
        //@todo make sure empty strig return null
        self::assertEquals('', $response->json("data.description"));
        self::assertFalse($response->json("data.is_active"));
        $expected_category_keys = ['id', 'name', 'description', 'is_active', 'created_at', 'updated_at'];
        $category_keys = array_keys($response->json('data'));
        self::assertEqualsCanonicalizing($expected_category_keys, $category_keys);
    }
    public function testCreateValidationError(): void
    {
        $response = $this->postJson(route('api.v1.categories.store'), []);
        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonFragment(["name" => ["The name field is required."]]);
    }
    public function testShow(): void
    {
        $category = factory(Category::class)->create(['name' => 'Teste 1']);
        $response = $this->getJson(route('api.v1.categories.show', ['category' => $category->id]));
        $categoryResource = new CategoryResource($category->refresh());
        $response->assertStatus(200)
        ->assertJsonFragment(['success' => true])
        ->assertJsonFragment(['data' => $categoryResource->resolve()]);
        $expected_category_keys = ['id', 'name', 'description', 'is_active', 'created_at', 'updated_at'];
        $category_keys = array_keys($response->json('data'));
        self::assertEqualsCanonicalizing($expected_category_keys, $category_keys);
    }
    public function testShowError():void
    {
        $response = $this->getJson(route('api.v1.categories.show', ['category' => Str::uuid()]));
        $response->assertStatus(404)
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['message' => 'Model not Found']);
    }

    public function testUpdate(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->putJson(
            route('api.v1.categories.update', ['category' => $category->id]),
            ['name' => 'Teste 1', 'description' => 'desc1', 'is_active' => false]
        );
        $response->assertJsonFragment(['name' => 'Teste 1', 'description' => 'desc1', 'is_active' => false]);
        $response = $this->putJson(
            route('api.v1.categories.update', ['category' => $category->id]),
            ['name' => 'Teste 2', 'description' => 'desc2']
        );
        $response->assertJsonFragment(['name' => 'Teste 2', 'description' => 'desc2']);
        $response = $this->putJson(
            route('api.v1.categories.update', ['category' => $category->id]),
            ['name' => 'Teste 3','is_active' => true]
        );
        $response->assertJsonFragment(['name' => 'Teste 3','is_active' => true]);
        $response = $this->putJson(
            route('api.v1.categories.update', ['category' => $category->id]),
            ['name' => 'Teste 4']
        );
        $response->assertJsonFragment(['name' => 'Teste 4']);
        $expected_category_keys = ['id', 'name', 'description', 'is_active', 'created_at', 'updated_at'];
        $category_keys = array_keys($response->json('data'));
        self::assertEqualsCanonicalizing($expected_category_keys, $category_keys);
    }
    public function testUpdateValidationError(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->putJson(
            route('api.v1.categories.update', ['category' => $category->id]),
            ['description' => 'desc2']
        );
        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonFragment([ "name" => ["The name field is required." ]]);
    }
    public function testUpdateModelError(): void
    {
        $response = $this->putJson(
            route('api.v1.categories.update', ['category' => Str::uuid()]),
            ['name' => 'Teste 1', 'description' => 'desc1', 'is_active' => false]
        );
        $response->assertStatus(404)
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['message' => 'Model not Found']);
    }

    public function testDelete(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->deleteJson(
            route('api.v1.categories.destroy', ['category' => $category->id])
        );
        $response->assertNoContent(204);
    }

    public function testDeleteModelError(): void
    {
        $response = $this->deleteJson(
            route('api.v1.categories.destroy', ['category' => Str::uuid()])
        );
        $response->assertStatus(404)
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['message' => 'Model not Found']);
    }
}
