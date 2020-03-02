<?php

use App\Task;
use Illuminate\Database\Seeder;

class TaskListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Christian Letourneau',
            'email' => 'let968@gmail.com'
        ])->each(function($user){
            $user->taskLists()->createMany(factory(App\TaskList::class, 3)->make()->toArray());
            $user->taskLists()->each(function($list){
                $list->tasks()->createMany(factory(Task::class, 10)->make()->toArray());
            });
        });
    }
}
