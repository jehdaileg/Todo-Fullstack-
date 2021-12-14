<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanGetTasks(): void {
        Task::factory(3)->create();

        $res = $this->getJson(route('tasks.index'));

        $res->assertOk();
        $res->assertJsonCount(3, 'data');
    }
}
