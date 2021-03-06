<?php

namespace Tests\Unit\Repository;

use App\Models\Category;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\CategoryRepository ;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Repository\Interfaces\EloquentRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;
/**
 * @group repository
 * @group category
 */
class CategoryRepositoryTest extends TestCase
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->categoryRepository = new CategoryRepository(new Category());
    }


    public function testInterfaces()
    {
        $expected_interfaces = [EloquentRepositoryInterface::class, CategoryRepositoryInterface::class];
        $interfaces = class_implements($this->categoryRepository);
        $categoryRepositoryInterfaces = array_values($interfaces);
        $this->assertEqualsCanonicalizing($expected_interfaces, $categoryRepositoryInterfaces);
    }

    public function testParents(){
        $expected_parents = [BaseRepository::class];
        $parents = class_parents($this->categoryRepository);
        $categoryRepositoryParents = array_values($parents);
        $this->assertEqualsCanonicalizing($expected_parents, $categoryRepositoryParents);
    }



}
