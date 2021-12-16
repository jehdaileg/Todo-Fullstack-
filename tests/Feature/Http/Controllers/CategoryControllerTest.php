<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class CategoryControllerTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    public function testUsersCanFetchAllCategories(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        Category::factory(5)->create();

        $res = $this->getJson(route('categories.index'));

        $res->assertOk();
    }

    public function testUsersCannotFetchCategoriesIfNotAuthenticated(): void
    {

        Category::factory(5)->create();

        $res = $this->getJson(route('categories.index'));

        $res->assertUnauthorized();
    }

    public function testUserCanStoreCategoryInDatabase(): void
    {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $res = $this->postJson(route('categories.store', [

            'name' => $this->faker->word()

        ]));

        $res->assertOk();
    }

    public function testUserCannotStoreCategoryIfHeIsNotAuthenticated(): void
    {

        $response = $this->postJson(route('categories.store'), [

            'name' => $this->faker->sentence()

        ]);

        $response->assertUnauthorized();
    }


    public function testUserCanGetAspecificCategory(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.show', $category->id));

        $response->assertOk();
    }

    public function testUserCannotGetAUnexistedCaetgory(): void
    {
        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

        $user = User::factory()->create();

        $this->actingAs($user);

        Category::factory()->create();

        $response = $this->getJson(route('categories.show', 75588));

        $response->assertNotFound();
    }

    public function testUserCannotGeAspecificCategoryIfNotAuthenticated(): void
    {

        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.show', $category->id));

        $response->assertUnauthorized();
    }
}
