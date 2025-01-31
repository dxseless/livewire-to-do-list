<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TodoList extends Component
{
    public $tasks;
    public $newTask = '';

    protected $rules = [
        'newTask' => 'required|min:3',
    ];

    public function mount()
    {
        $this->tasks = Task::all();
    }

    public function addTask()
    {
        $this->validate();

        Task::create([
            'description' => $this->newTask,
            'completed' => false,
        ]);

        $this->newTask = '';
        $this->tasks = Task::all();
    }

    public function toggleTask($id)
    {
        $task = Task::find($id);
        $task->completed = !$task->completed;
        $task->save();

        $this->tasks = Task::all();
    }

    public function deleteTask($id)
    {
        Task::destroy($id);
        $this->tasks = Task::all();
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}