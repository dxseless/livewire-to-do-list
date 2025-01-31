<div>
    <h1>To-Do List</h1>

    <form wire:submit.prevent="addTask">
        <input type="text" wire:model="newTask" placeholder="Добавить новую задачу">
        <button type="submit">Добавить</button>
    </form>

    <ul>
        @foreach($tasks as $task)
            <li>
                <input
                    type="checkbox"
                    wire:change="toggleTask({{ $task->id }})"
                    {{ $task->completed ? 'checked' : '' }}
                >
                <span style="{{ $task->completed ? 'text-decoration: line-through' : '' }}">
                    {{ $task->description }}
                </span>
                <button wire:click="deleteTask({{ $task->id }})">Удалить</button>
            </li>
        @endforeach
    </ul>
</div>