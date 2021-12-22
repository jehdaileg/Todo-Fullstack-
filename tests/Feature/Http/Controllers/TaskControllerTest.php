<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testUsersCanGetTasks(): void {
            /**
             *
             *
             * @var \Illuminate\Contracts\Auth\Authenticatable $user
             */
        $user = User::factory()->create();
        Task::factory(3)->create();

        $this->actingAs($user);


        $res = $this->getJson(route('tasks.index'));

        //$res->assertUnauthorized();

        $res->assertOk();
    }

    public function testUsersCanGetOneTask(): void
    {
        $user = User::factory()->create();

        $task = Task::factory()->create();

        Sanctum::actingAs($user);

        $res = $this->getJson(route('tasks.show', $task->id));

       $res->assertOk();
    }

    public function testItWillReturnNotFoundIfATaskIdIsIncorrect(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $res = $this->getJson(route('tasks.show', 5000));

        $res->assertNotFound();
    }


    public function testUserCansDeleteTask(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $task = Task::factory()->create();

        $res = $this->delete(route('tasks.destroy', $task->id));

        $res->assertOk();
    }

        /**
         *
         * @test
         */
    public function CannotGetTasksIfNotAuth(): void {
        Task::factory(3)->create();


        $res = $this->getJson(route('tasks.index'));

        $res->assertUnauthorized();
    }

    public function testUserCanGetOneTask():void {

          /**
             *
             *
             * @var \Illuminate\Contracts\Auth\Authenticatable $user
             */
        $user = User::factory()->create();

        $task = Task::factory()->create();

        //$task = Task::find();

        $this->actingAs($user);

        $res = $this->getJson(route('tasks.show', $task->id));

        //$res->dd();

        $res->assertOk();


    }

    public function testIfTheTaskIdIsCorrect(): void {

      /**
             *
             *
             * @var \Illuminate\Contracts\Auth\Authenticatable $user
             */
            $user = User::factory()->create();

            $this->actingAs($user);

            $res = $this->getJson(route('tasks.show', 5000));

            $res->assertNotFound();

    }

    public function testUserCanCreateTask(): void {


        /**
           *
           *
           * @var \Illuminate\Contracts\Auth\Authenticatable $user
           */
          $user = User::factory()->create();
          $this->actingAs($user);


          $res = $this->postJson(route('tasks.store', [
              'title' => $this->faker->sentence(),


          ]));

          //$res->dump();

         // $res->dd();

         $res->assertStatus(200);

  }

    public function testUserCanDeleteTask(): void {

        /**
           *
           *
           * @var \Illuminate\Contracts\Auth\Authenticatable $user
           */
          $user = User::factory()->create();
          $this->actingAs($user);

          $task = Task::factory()->create();


          $res = $this->delete(route('tasks.destroy', $task->id));

          $res->assertOk();

   // $res->dd();
    }


}
