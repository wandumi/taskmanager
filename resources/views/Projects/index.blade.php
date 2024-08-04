@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Projects</h1>

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Project Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Project</button>
        </form>


        <ul class="list-group mt-3">
            @foreach($projects as $project)
                <li class="list-group-item">
                    {{ $project->name }}
                </li>
            @endforeach
        </ul>

    </div>
    @endsection
