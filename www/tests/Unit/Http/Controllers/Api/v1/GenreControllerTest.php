<?php

namespace Tests\Unit\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\GenreController;
use App\Http\Requests\Genre\v1\GenreStoreRequest;
use App\Http\Requests\Genre\v1\GenreUpdateRequest;
use Tests\TestCase;
use Tests\Traits\AdditionalAssertions;

/**
 * @group controller
 * @group category
 */
class GenreControllerTest extends TestCase
{
    use AdditionalAssertions;

    public function testUsesFormRequest()
    {
        $this->assertActionUsesFormRequest(GenreController::class, 'store', GenreStoreRequest::class);
        $this->assertActionUsesFormRequest(GenreController::class, 'update', GenreUpdateRequest::class);
    }
}
