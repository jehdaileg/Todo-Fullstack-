<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUsersCanGetTasks(): void {
        /**@var \Illuminate\Contracts\Auth\Authenticatable $user*/
        $user = User::factory()->create();
        Task::factory(3)->create();
        
        $this->actingAs($user);

        $res = $this->getJson(route('tasks.index'));

        $res->assertOk();
        $res->assertJsonCount(3, 'data');
    }

    /**
     * @test
     */
    public function usersCannotGetTasksIfTheyAreNotAuthentified(): void {
        $res = $this->getJson(route('tasks.index'));

        $res->assertUnauthorized();
    }

    /**
     * @test
     */
    public function usersCanShowATask(): void {
        $task = Task::factory()->create();
        /**@var \Illuminate\Contracts\Auth\Authenticatable $user*/
        $user = User::factory()->create();

        $res = $this->actingAs($user)->getJson(
            route('tasks.show', $task->id)
        );

        $res->assertOk();
        $res->assertJsonPath('data.title', $task->title);
    }

    /**
     * @test
     */
    public function usersWillGetNotFoundIfATaskDoesNotExist(): void {
        /**@var \Illuminate\Contracts\Auth\Authenticatable $user*/
        $user = User::factory()->create();

        $res = $this->actingAs($user)->getJson(
            route('tasks.show', 1)
        );

        $res->assertNotFound();
    }

    /**
     * @test
     */
    public function usersCanCreateATask(): void {
        /**@var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

      //  $this->withoutExceptionHandling();

        $res = $this->actingAs($user)->postJson(
            route('tasks.store', [
                'title' => $this->faker->sentence()
            ])
        );

        $res->dump();
    }
}
