<div class="todo-list">
    <h1>To-Do List</h1>

    <!-- Форма для добавления новой задачи -->
    <form wire:submit.prevent="addTask" class="add-task-form">
        <input
            type="text"
            wire:model="newTask"
            placeholder="Добавить новую задачу"
            class="task-input"
        >
        <button type="submit" class="add-button">Добавить</button>
    </form>

    <!-- Фильтры -->
    <div class="filters">
        <button wire:click="setFilter('all')" class="{{ $filter === 'all' ? 'active' : '' }}">Все</button>
        <button wire:click="setFilter('active')" class="{{ $filter === 'active' ? 'active' : '' }}">Активные</button>
        <button wire:click="setFilter('completed')" class="{{ $filter === 'completed' ? 'active' : '' }}">Завершенные</button>
    </div>

    <!-- Список задач -->
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