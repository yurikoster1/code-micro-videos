<?php
namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseResetTest extends TestCase
{
    use DatabaseMigrations;

    public function test_changes_persist_inside_test()
    {
        factory(Category::class, 10)->create();
        self::assertGreaterThan(0, Category::count());

        Category::truncate();

        self::assertEquals(0, Category::count());
    }

    public function test_resets_database_between_tests()
    {
        self::assertEquals(0, Category::count());
    }

}
