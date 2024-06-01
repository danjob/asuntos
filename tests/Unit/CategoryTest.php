<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\UsersSeeder;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_can_be_indexed()
    {
        $this->seed(UsersSeeder::class);
        $this->seed(CategoriesSeeder::class);
        $this->actingAs(User::first());

        $response = $this->get(route('categories.index'));

        $categoryCount = count(json_decode($response->content()));

        $this->assertGreaterThan(0, $categoryCount);
    }
}
