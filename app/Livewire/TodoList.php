<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TodoList extends Component
{
    public $tasks;
    public $newTask = '';
    public $filter = 'all';
    public $editingTaskId = null;
    public $editingTaskDescription = '';

    protected $rules = [
        'newTask' => 'required|min:3',
        'editingTaskDescription' => 'required|min:3',
    ];

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        if ($this->filter === 'active') {
            $this->tasks = Task::where('completed', false)->get();
        } elseif ($this->filter === 'completed') {
            $this->tasks = Task::where('completed', true)->get();
        } else {
            $this->tasks = Task::all();
        }
    }

    public function addTask()
    {
        $this->validate(['newTask' => 'required|min:3']);

        Task::create([
            'description' => $this->newTask,
            'completed' => false,
        ]);

        $this->newTask = '';
        $this->loadTasks();
    }

    public function toggleTask($id)
    {
        $task = Task::find($id);
        $task->completed = !$task->completed;
        $task->save();

        $this->loadTasks();
    }

    public function deleteTask($id)
    {
        Task::destroy($id);
        $this->loadTasks();
    }

    public function editTask($id)
    {
        $task = Task::find($id);
        $this->editingTaskId = $task->id;
        $this->editingTaskDescription = $task->description;
    }

    public function updateTask()
    {
        $this->validate(['editingTaskDescription' => 'required|min:3']);

        $task = Task::find($this->editingTaskId);
        $task->description = $this->editingTaskDescription;
        $task->save();

        $this->cancelEditing();
        $this->loadTasks();
    }

    public function cancelEditing()
    {
        $this->editingTaskId = null;
        $this->editingTaskDescription = '';
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->loadTasks();
    }

    public function getRemainingTasksCount()
    {
        return Task::where('completed', false)->count();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'remainingTasksCount' => $this->getRemainingTasksCount(),
        ]);
    }
}