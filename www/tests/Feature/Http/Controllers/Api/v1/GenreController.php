<?php

namespace Tests\Feature\Http\Controllers\Api\v1;

use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;
/**
 * @group controller
 * @group genre
 */
class GenreController extends TestCase
{
    use DatabaseMigrations;
    /**
     * A test Genre List.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->getJson(route('api.v1.genres.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
        $response->assertJsonFragment(['success' => true]);
        $genres= factory(Genre::class, 10)->create(['is_active' => false]);
        $genresResource = GenreResource::collection($genres);
        $response = $this->getJson(route('api.v1.genres.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonFragment(['success' => true]);
        $response->assertJsonFragment(['data' => $genresResource->resolve()]);
        $expected_genre_keys = ['id', 'name',  'is_active', 'created_at', 'updated_at'];
        $genre_keys = array_keys($response->json('data')[0]);
        self::assertEqualsCanonicalizing($expected_genre_keys, $genre_keys);
    }

    public function testCreate(): void
    {
        $response = $this->postJson(route('api.v1.genres.store'), ['name' => 'Teste 1']);
        self::assertEquals('Teste 1', $response->json('data.name'));
        $uuid = $response->json("data.id");
        $isUUID = preg_match('/[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid);
        self::assertEquals(1, $isUUID);
        self::assertTrue($response->json("data.is_active"));
        $response = $this->postJson(route('api.v1.genres.store'), ['name' => 'Teste 2']);
        self::assertEquals('Teste 2', $response->json("data.name"));
        self::assertTrue($response->json("data.is_active"));
        $response = $this->postJson(
            route('api.v1.genres.store'),
            ['name' => 'Teste 3', 'is_active' => true]
        );
        self::assertEquals(
            'Teste 3',
            $response->json("data.name")
        );
        self::assertTrue($response->json("data.is_active"));
        $response = $this->postJson(
            route('api.v1.genres.store'),
            ['name' => 'Teste 4', 'is_active' => false]
        );
        self::assertEquals('Teste 4', $response->json("data.name"));
        $expected_genre_keys = ['id', 'name',  'is_active', 'created_at', 'updated_at'];
        $genre_keys = array_keys($response->json('data'));
        self::assertEqualsCanonicalizing($expected_genre_keys, $genre_keys);
    }
    public function testCreateValidationError(): void
    {
        $response = $this->postJson(route('api.v1.genres.store'), []);
        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonFragment(["name" => ["The name field is required."]]);
    }
    public function testShow(): void
    {
        $genre = factory(Genre::class)->create(['name' => 'Teste 1']);
        $response = $this->getJson(route('api.v1.genres.show', ['genre' => $genre->id]));
        $genreResource = new GenreResource($genre->refresh());
        $response->assertStatus(200)
        ->assertJsonFragment(['success' => true])
        ->assertJsonFragment(['data' => $genreResource->resolve()]);
        $expected_genre_keys = ['id', 'name',  'is_active', 'created_at', 'updated_at'];
        $genre_keys = array_keys($response->json('data'));
        self::assertEqualsCanonicalizing($expected_genre_keys, $genre_keys);
    }
    public function testShowError():void
    {
        $response = $this->getJson(route('api.v1.genres.show', ['genre' => Str::uuid()]));
        $response->assertStatus(404)
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['message' => 'Model not Found']);
    }

    public function testUpdate(): void
    {
        $genre = factory(Genre::class)->create();
        $response = $this->putJson(
            route('api.v1.genres.update', ['genre' => $genre->id]),
            ['name' => 'Teste 1',  'is_active' => false]
        );
        $response->assertJsonFragment(['name' => 'Teste 1', 'is_active' => false]);
        $response = $this->putJson(
            route('api.v1.genres.update', ['genre' => $genre->id]),
            ['name' => 'Teste 3','is_active' => true]
        );
        $response->assertJsonFragment(['name' => 'Teste 3','is_active' => true]);
        $response = $this->putJson(
            route('api.v1.genres.update', ['genre' => $genre->id]),
            ['name' => 'Teste 4']
        );
        $response->assertJsonFragment(['name' => 'Teste 4']);
        $expected_genre_keys = ['id', 'name',  'is_active', 'created_at', 'updated_at'];
        $genre_keys = array_keys($response->json('data'));
        self::assertEqualsCanonicalizing($expected_genre_keys, $genre_keys);
    }
    public function testUpdateValidationError(): void
    {
        $genre = factory(Genre::class)->create();
        $response = $this->putJson(
            route('api.v1.genres.update', ['genre' => $genre->id]),
            ['nonsense '=> 'desc2']
        );
        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonFragment([ "name" => ["The name field is required." ]]);
    }
    public function testUpdateModelError(): void
    {
        $response = $this->putJson(
            route('api.v1.genres.update', ['genre' => Str::uuid()]),
            ['name' => 'Teste 1',  'is_active' => false]
        );
        $response->assertStatus(404)
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['message' => 'Model not Found']);
    }

    public function testDelete(): void
    {
        $genre = factory(Genre::class)->create();
        $response = $this->deleteJson(
            route('api.v1.genres.destroy', ['genre' => $genre->id])
        );
        $response->assertNoContent(204);
    }

    public function testDeleteModelError(): void
    {
        $response = $this->deleteJson(
            route('api.v1.genres.destroy', ['genre' => Str::uuid()])
        );
        $response->assertStatus(404)
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['message' => 'Model not Found']);
    }
}
