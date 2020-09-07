<?php

namespace Tests\Unit\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Requests\Category\v1\CategoryStoreRequest;
use App\Http\Requests\Category\v1\CategoryUpdateRequest;
use Tests\TestCase;
use Tests\Traits\AdditionalAssertions;

/**
 * @group controller
 * @group category
 */
class CategoryControllerTest extends TestCase
{
    use AdditionalAssertions;

    public function testUsesFormRequest()
    {
        $this->assertActionUsesFormRequest(CategoryController::class, 'store', CategoryStoreRequest::class);
        $this->assertActionUsesFormRequest(CategoryController::class, 'update', CategoryUpdateRequest::class);
    }
}
