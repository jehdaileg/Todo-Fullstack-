<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const DEVICE_NAME = 'Samsung';

    public function testUsersCanGetTasks(): void
    {
        

        $user = User::factory()->create();
        Task::factory(3)->for($user)->create();

        $token = $user->createToken(self::DEVICE_NAME)->plainTextToken;

        Sanctum::actingAs($user);

        $res = $this->getJson(route('tasks.index'), [
             'headers' => [
                    'Authorization' => 'Bearer '. $token,
                    'Accept' => 'application/json'
                ]
        ]);

        $res->assertOk();
        $res->assertJsonCount(3, 'data');
    }

    /**
     *
     * @test
     */
    public function CannotGetTasksIfNotAuthenticated(): void
    {
        Task::factory(3)->create();

        $res = $this->getJson(route('tasks.index'));

        $res->assertUnauthorized();
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

    public function testUsersCanCreateTask(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $res = $this->postJson(route('tasks.store', [
            'title' => $this->faker->sentence(),
        ]));

        $res->assertOk();
    }

    public function testUserCansDeleteTask(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $task = Task::factory()->create();

        $res = $this->delete(route('tasks.destroy', $task->id));

        $res->assertOk();
    }
}
