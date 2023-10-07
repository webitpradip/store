<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostController extends Controller
{

public function index(Request $request)
{
    $search = $request->query('search');
    $query = Post::query();

    if ($search) {
        $search = str_ireplace(" ","%",$search);
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
        $data['filelinks'] = 'uploads/' .$request->groupname.'/'. $filename;
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
        $data['filelinks'] = 'uploads/' .$request->groupname.'/'. $filename;
    }

    $post->update($data);

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
}

public function download(Post $post)
{
    // Ensure the file exists before attempting to download
    if (Storage::disk('public')->exists($post->filelinks)) {
        return Storage::disk('public')->download($post->filelinks);
    }

    return back()->with('error', 'File not found.');
}

public function downloadBackup(){
    $config = config('database.connections.mysql');
    $command = sprintf(
        'mysqldump --user=%s --password=%s --host=%s %s > %s',
        $config['username'],
        $config['password'],
        $config['host'],
        $config['database'],
        storage_path('app/public/db_backup.sql')
    );

    shell_exec($command);

    $zipFile = storage_path('app/public/storage_and_db.zip');
$zip = new \ZipArchive();

if ($zip->open($zipFile, \ZipArchive::CREATE) === TRUE) {
    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(storage_path('app/public')),
        \RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = 'storage/public/' . substr($filePath, strlen(storage_path('app/public')) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
}

$zipFileName = 'storage_and_db.zip';
$dbBackupFileName = 'db_backup.sql';

$response = new StreamedResponse(function () use ($zipFileName, $dbBackupFileName) {
    // Stream the file to the user
    $stream = Storage::disk('public')->readStream($zipFileName);
    fpassthru($stream);
    if (is_resource($stream)) {
        fclose($stream);
    }

    // After streaming the file, delete the files
    Storage::disk('public')->delete($zipFileName);
    Storage::disk('public')->delete($dbBackupFileName);
});

$response->headers->set('Content-Type', 'application/zip');
$response->headers->set('Content-Disposition', 'attachment; filename="' . $zipFileName . '"');

return $response;
}

}
