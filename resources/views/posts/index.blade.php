@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->query('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>File Preview</th>
                    <th>Group Name</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                      @if(!empty($post->filelinks))
                      @php
    $extension = pathinfo($post->filelinks, PATHINFO_EXTENSION);
    @endphp

    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
    <img src="{{ asset(\Storage::url($post->filelinks)) }}" alt="Image" width="50">
    @elseif(in_array($extension, ['mp4', 'webm']))
    <video width="100" controls>
        <source src="{{ asset(\Storage::url($post->filelinks)) }}" type="video/{{ $extension }}">
        Your browser does not support the video tag.
    </video>
    @else
    <i class="fas fa-file-alt fa-2x"></i> <!-- Default Font Awesome file icon -->
    @endif
    <br>
    <a href="{{ route('post.download', $post->id) }}">Download</a>

    @endif
                    </td>
                    <td>{{ $post->groupname }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-success">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $posts->appends(['search' => request()->query('search')])->links() }}
    </div>
</div>
@endsection
