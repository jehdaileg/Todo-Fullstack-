<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
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

        $res->assertOk();
        $res->assertJsonCount(3, 'data');
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

         $res->assertOk();

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
    }


}
