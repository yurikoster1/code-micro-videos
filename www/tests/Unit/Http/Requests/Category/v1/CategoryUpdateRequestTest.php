<?php

namespace Tests\Unit\Http\Requests\Category\v1;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\Category\Interfaces\CategoryUpdateRequestInterface;
use App\Http\Requests\Category\v1\CategoryBaseRequest;
use App\Http\Requests\Category\v1\CategoryUpdateRequest;
use Faker\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request as FoundationRequest;
use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;

/**
 * @group requests
 * @group category
 */
class CategoryUpdateRequestTest extends TestCase
{
    private $categoryRequest;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->categoryRequest = new CategoryUpdateRequest([]);
    }

    public function testInterfaces()
    {
        $expected_interfaces = [CategoryUpdateRequestInterface::class, ArrayAccess::class, Arrayable::class, ValidatesWhenResolved::class];
        $interfaces = class_implements($this->categoryRequest);
        $categoryRequestInterfaces = array_values($interfaces);
        $this->assertEqualsCanonicalizing($expected_interfaces, $categoryRequestInterfaces);
    }

    public function testParents()
    {
        $expected_parents = [CategoryBaseRequest::class, BaseRequest::class, FormRequest::class, Request::class, FoundationRequest::class];
        $parents = class_parents($this->categoryRequest);
        $categoryRequestParents = array_values($parents);
        $this->assertEqualsCanonicalizing($expected_parents, $categoryRequestParents);
    }

    public function test_CategoryUpdateRequest_empty()
    {
        try {
            $request = new CategoryUpdateRequest([]);
            $request
                ->setContainer(app())
                ->setRedirector(app(Redirector::class))
                ->validateResolved();
        } catch (ValidationException $ex) {
            print_r($ex->errors(), true);
        }
        //\Log::debug(print_r($ex->errors(), true));
        self::assertTrue(isset($ex));
        self::assertArrayHasKey('name', $ex->errors());
    }


    public function test_CategoryUpdateRequest_success()
    {
        $faker = FakerFactory::create();
        $param = [
            'name' => $faker->colorName,
            'description' => $faker->text,
            'is_active' => $faker->boolean,
        ];
        try {
            $request = new CategoryUpdateRequest($param);
            $request
                ->setContainer(app())
                ->setRedirector(app(Redirector::class))
                ->validateResolved();
        } catch (ValidationException $ex) {
        }

        self::assertFalse(isset($ex));
    }

    /**
     * @dataProvider provideValidData
     */
    public function testValidData(array $data)
    {
        $request = new CategoryUpdateRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function provideValidData()
    {
        $faker = \Faker\Factory::create(Factory::DEFAULT_LOCALE);

        return [
            [[
                'name' => 'test',
                'description' => 'this is a test'
            ]],
            [[
                'name' => $faker->colorName,
                'description' => $faker->text,
                'is_active' => $faker->boolean,
            ]],
            [[
                'name' => $faker->colorName,
                'description' => null,
                'is_active' => $faker->boolean,
            ]]
            // ...
        ];
    }
    /**
     * @dataProvider provideInvalidData
     */
    public function testInvalidData(array $data)
    {
        $request = new CategoryUpdateRequest();

        $validator = Validator::make($data, $request->rules());


        $this->assertFalse($validator->passes());
    }

    public function provideInvalidData()
    {
        $faker = \Faker\Factory::create(Factory::DEFAULT_LOCALE);
        return [
            [[]], // missing fields
            [[
                'title' => 'test' // missing body
            ]],
            [[
                'description' => $faker->text,
                'is_active' => $faker->boolean, // missing name
            ]],
            [[
                'name' => str_repeat('a', CategoryBaseRequest::NAME_MAX_LENGTH + 1), // title too long
                'description' => $faker->text,
            ]],
            [[
                'name' => $faker->colorName,
                'description' => $faker->text,
                'is_active' => 'true',
            ]],
            [[
                'name' => $faker->colorName,
                'description' => $faker->text,
                'is_active' => 'false',
            ]]
            // ...
        ];
    }
}
