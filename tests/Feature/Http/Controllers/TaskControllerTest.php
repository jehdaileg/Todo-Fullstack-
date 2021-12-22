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
        $user = User::factory()->create();
        Task::factory(3)->create();

        $this->actingAs($user);


        $res = $this->getJson(route('tasks.index'));

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


    public function testUserCanGetOneTask():void {

        $user = User::factory()->create();

        $task = Task::factory()->create();

        Sanctum::actingAs($user);

        $res = $this->getJson(route('tasks.show', $task->id));

        $res->assertOk();


    }

    

    public function testUserCanCreateTask(): void {

          $user = User::factory()->create();
          
          Sanctum::actingAs($user);


          $res = $this->postJson(route('tasks.store', [
              'title' => $this->faker->sentence(),

          ]));

         $res->assertStatus(200);

  }

    public function testUserCanDeleteTask(): void {

    
          $user = User::factory()->create();
      
          $task = Task::factory()->create();

          Sanctum::actingAs($user);
      
          $res = $this->deleteJson(route('tasks.destroy', $task->id));

          $res->assertOk();
    }


}
