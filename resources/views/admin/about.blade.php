@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <h1>Edit About Page</h1>
    <form action="{{ route('admin.about') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="about">About Me</label>
            <textarea name="about" id="about" rows="15" class="form-control">{{ $contents }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Update</button>
</div>
@endsection