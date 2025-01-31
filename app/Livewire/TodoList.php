<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Category;

class TodoList extends Component
{
    public $tasks;
    public $newTask = '';
    public $filter = 'all';
    public $editingTaskId = null;
    public $editingTaskDescription = '';
    public $searchQuery = '';
    public $categories;
    public $selectedCategory = null;
    public $newCategory = '';

    protected $rules = [
        'newTask' => 'required|min:3',
        'editingTaskDescription' => 'required|min:3',
        'newCategory' => 'required|min:3',
    ];

    public function mount()
    {
        $this->loadTasks();
        $this->loadCategories();
    }

    public function loadTasks()
    {
        $query = Task::query();

        if ($this->filter === 'active') {
            $query->where('completed', false);
        } elseif ($this->filter === 'completed') {
            $query->where('completed', true);
        }

        if ($this->searchQuery) {
            $query->where('description', 'like', '%' . $this->searchQuery . '%');
        }

        if ($this->selectedCategory) {
            $query->whereHas('categories', function ($q) {
                $q->where('categories.id', $this->selectedCategory);
            });
        }

        $this->tasks = $query->get();
    }

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function addTask()
    {
        $this->validate(['newTask' => 'required|min:3']);

        $task = Task::create([
            'description' => $this->newTask,
            'completed' => false,
        ]);

        if ($this->selectedCategory) {
            $task->categories()->attach($this->selectedCategory);
        }

        $this->newTask = '';
        $this->loadTasks();
    }

    public function addCategory()
    {
        $this->validate(['newCategory' => 'required|min:3']);

        Category::create(['name' => $this->newCategory]);
        $this->newCategory = '';
        $this->loadCategories();
    }

    public function setCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
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

    public function searchTasks()
    {
        $this->loadTasks();
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