@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">

            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea rows="10" name="description" class="form-control" required>{{ $post->description }}</textarea>
            </div>
            <div class="form-group">
                <label>File:</label>
                <input type="file" name="filelinks" class="form-control">
                <small>Current File: {{ $post->filelinks }}</small>
            </div>
            <div class="form-group">
                <label>Group Name:</label>
                <input type="text" name="groupname" class="form-control" value="{{ $post->groupname }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</div>
@endsection
