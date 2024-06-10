<?php

use function Livewire\Volt\{state, with};
use \App\Models\Todo;

state(['task']);

with([
    'todos' => fn() => auth()->user()->todos
]);

$add = function(){
    auth()->user()->todos()->create([
        'task' => $this->task
]);

    Mail::to(auth()->user())
        ->queue(new TodoCreated($todo));
    $this->task = '';
};

$delete = fn(Todo $todo) => $todo->delete(); 

?>

<div>
    <form wire:submit='add'>
        <input type="text" wire:model='task'>
        <button type='submit'>Add</button>
    </form>

    <div>
        @foreach($todos as $todo)
        <div>
            {{ $todo->task}}
            <button wire:click='delete({{ $todo->id }})'>X</button>
        </div>
        @endforeach
    </div>

</div>
