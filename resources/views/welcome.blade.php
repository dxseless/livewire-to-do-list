<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
    @livewireStyles
</head>
<body>
    <div class="container">
        @livewire('todo-list') 
    </div>

    @livewireScripts
</body>
</html>