<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

public function index(Request $request)
{
    $search = $request->query('search');
    $query = Post::query();

    if ($search) {
        $query->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('groupname', 'LIKE', "%{$search}%");
    }

    $posts = $query->paginate(10);

    return view('posts.index', compact('posts'));
}

public function create()
{
    return view('posts.create');
}


public function edit($id)
{
    $post = Post::findOrFail($id);
    return view('posts.edit', compact('post'));
}

public function store(Request $request)
{
    $data = $request->all();

    // Handle the file upload
    if ($request->hasFile('filelinks')) {
        $file = $request->file('filelinks');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/'.$request->groupname, $filename, 'public');
        $data['filelinks'] = '/storage/' . $path;
    }

    Post::create($data);

    return redirect()->route('posts.index')->with('success', 'Post created successfully.');
}
public function update(Request $request, $id)
{
    $post = Post::findOrFail($id);
    $data = $request->all();

    // Handle the file upload
    if ($request->hasFile('filelinks')) {
        // Delete old file if needed
        if (file_exists(public_path($post->filelinks)) && !empty($post->filelinks)) {
            unlink(public_path($post->filelinks));
        }

        $file = $request->file('filelinks');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/'.$request->groupname, $filename, 'public');
        $data['filelinks'] = '/storage/' . $path;
    }

    $post->update($data);

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
}


}
