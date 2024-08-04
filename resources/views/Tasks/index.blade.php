@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tasks</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Task Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="project_id">Project</label>
                <select class="form-control" id="project_id" name="project_id" required>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ $project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <ul id="tasks-list" class="list-group mt-3">
            @foreach ($tasks as $task)
                <li class="list-group-item" data-id="{{ $task->id }}">
                    {{ $task->name }}
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="float-right">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-info float-right mr-2">Edit</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#tasks-list").sortable({
                update: function(event, ui) {
                    let taskOrder = $(this).sortable('toArray', {
                        attribute: 'data-id'
                    });

                    $.post('{{ route('tasks.reorder') }}', {
                        _token: '{{ csrf_token() }}',
                        tasks: taskOrder
                    }, function(response) {
                        console.log('Tasks reordered successfully');
                    }).fail(function(xhr, status, error) {
                        console.error('Reordering failed:', error);
                    });
                }
            });
        });
    </script>
@endsection
