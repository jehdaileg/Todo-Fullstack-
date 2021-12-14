<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
//use Illuminate\Foundation\Auth\User;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */



    public function testUsersCanGetCategoryHomeEndPointIndex() : void {

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */
        $user = User::factory()->create();

        $this->actingAs($user);

        $res = $this->get(url('/'));

        $res->assertStatus(200);

    }

    public function testUsersCanFetchAllCategories() : void {
        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

         $user = User::factory()->create();

         $this->actingAs($user);

         Category::factory(5)->create();

         $res = $this->getJson(route('categories.index'));

         $res->assertOk();

         $res->dump();


    }

    public function testUserCannotFetchCategoriesIfHeIsNotAuth() : void {

        Category::factory(5)->create();

        $res = $this->getJson(route('categories.index'));

        $res->assertUnauthorized();

    }

    public function testUserCanStoreCategoryInDatabase() : void {
          /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

          $user = User::factory()->create();

          $this->actingAs($user);

          $res = $this->postJson(route('categories.store', [

            'name' => $this->faker->sentence()

          ]));

          $res->assertOk();

          //$res->dd();

    }

    public function testUserCannotStoreCategoryIfHeIsNotAuth() : void {

       $response = $this->postJson(route('categories.store'), [

        'name' => $this->faker->sentence()

       ]);

       $response->assertUnauthorized();
    }


    public function testUserCanGetAspecificCategory() : void {
          /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

          $user = User::factory()->create();

          $this->actingAs($user);

          $category = Category::factory()->create();

          $response = $this->getJson(route('categories.show', $category->id));

          $response->assertOk();


    }

    public function testUserCannotGetAUnexistedCaetgory() : void {
          /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

        $user = User::factory()->create();

        $this->actingAs($user);

        Category::factory()->create();

        $response = $this->getJson(route('categories.show', 75588));

        $response->assertNotFound();

    }

    public function testUserCannotGeAspecificCategoryIfNotAuth() : void {

        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.show', $category->id));

        $response->assertUnauthorized();

    }


}

