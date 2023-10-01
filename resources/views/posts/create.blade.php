@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" class="form-control" required rows="10"></textarea>
            </div>
            <div class="form-group">
                <label>File:</label>
                <input type="file" name="filelinks" class="form-control" >
            </div>
            <div class="form-group">
                <label>Group Name:</label>
                <input type="text" name="groupname" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: green">Submit</button>
        </form>
    </div>
</div>
@endsection
