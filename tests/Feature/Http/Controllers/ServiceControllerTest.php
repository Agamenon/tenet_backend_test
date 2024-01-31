<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\ServiceTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /**
     * A basic feature test example.
     */
    public function test_services_list(): void
    {
        $services = ServiceTypeEnum::asArray();

        $response = $this->getJson(route("service.index"))->assertSuccessful()->assertJsonCount(count($services),"data");
    }
}
