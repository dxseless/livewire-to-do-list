<div class="todo-list">
    <h1>To-Do List</h1>

    <div class="category-form">
        <input
            type="text"
            wire:model="newCategory"
            placeholder="Добавить новую категорию"
            class="task-input"
        >
        <button wire:click="addCategory" class="add-button">Добавить категорию</button>
    </div>

    <div class="categories">
        <button wire:click="setCategory(null)" class="{{ $selectedCategory === null ? 'active' : '' }}">Все категории</button>
        @foreach($categories as $category)
            <button wire:click="setCategory({{ $category->id }})" class="{{ $selectedCategory === $category->id ? 'active' : '' }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <form wire:submit.prevent="addTask" class="add-task-form">
        <input
            type="text"
            wire:model="newTask"
            placeholder="Добавить новую задачу"
            class="task-input"
        >
        <select wire:model="selectedCategory" class="task-input">
            <option value="">Без категории</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="add-button">Добавить</button>
    </form>

    <div class="search-form">
        <input
            type="text"
            wire:model="searchQuery"
            placeholder="Поиск задач..."
            class="task-input search-input"
        >
        <button wire:click="searchTasks" class="search-button">Найти</button>
    </div>

    <div class="filters">
        <button wire:click="setFilter('all')" class="{{ $filter === 'all' ? 'active' : '' }}">Все</button>
        <button wire:click="setFilter('active')" class="{{ $filter === 'active' ? 'active' : '' }}">Активные</button>
        <button wire:click="setFilter('completed')" class="{{ $filter === 'completed' ? 'active' : '' }}">Завершенные</button>
    </div>

    <ul class="task-list">
        @foreach($tasks as $task)
            <li class="task-item {{ $task->completed ? 'completed' : '' }}">
                @if($editingTaskId === $task->id)
                    <form wire:submit.prevent="updateTask" class="edit-form">
                        <input
                            type="text"
                            wire:model="editingTaskDescription"
                            class="edit-input"
                        >
                        <button type="submit" class="save-button">Сохранить</button>
                        <button type="button" wire:click="cancelEditing" class="cancel-button">Отмена</button>
                    </form>
                @else
                    <input
                        type="checkbox"
                        wire:change="toggleTask({{ $task->id }})"
                        {{ $task->completed ? 'checked' : '' }}
                        class="task-checkbox"
                    >
                    <span class="task-description">{{ $task->description }}</span>
                    <div class="task-categories">
                        @foreach($task->categories as $category)
                            <span class="task-category">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    <button wire:click="editTask({{ $task->id }})" class="edit-button">✏️</button>
                    <button wire:click="deleteTask({{ $task->id }})" class="delete-button">❌</button>
                @endif
            </li>
        @endforeach
    </ul>

    <div class="remaining-tasks">
        Осталось задач: {{ $remainingTasksCount }}
    </div>
</div>