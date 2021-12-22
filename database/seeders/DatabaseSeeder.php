<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Task::factory(5)
        ->for($franssen = User::factory()->create(['name'=> 'franssen', 'email' => 'franssen@gmail.com', 'password' => 'secret']))
        ->for(Category::factory())
        ->create(); // tasks for Franssen not completed

        Task::factory(3)
        ->for($franssen)
        ->for(Category::factory())
        ->completed()
        ->create(); //Franssen's tasks completed

        Task::factory(5)
        ->for(User::factory()
        ->create())
        ->for(Category::factory())
        ->create();  //Tasks for other users not completed
    }


}
