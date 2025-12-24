<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Manajemen\MPosts;
use App\Models\Manajemen\MModul;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;
use Illuminate\Support\Facades\Storage;

class MPostsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'judul_posts' => 'required|string|max:255',
            'id_modul' => 'nullable|exists:m_modul,id',
            'parent_post_id' => 'nullable|exists:t_posts,id',
            'file' => 'nullable|file|mimes:md|max:10240',  // Validation for .md file (max 10MB)
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            // Store the file in the 'posts' directory under 'public'
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();  // Ensure unique file name
            $filePath = $file->storeAs('posts', $fileName, 'public');  // Store file and get its path
        }

        // Create the new post record
        $post = MPosts::create([
            'judul_posts' => $validated['judul_posts'],
            'id_modul' => $validated['id_modul'],
            'parent_post_id' => $validated['parent_post_id'],
            'filename' => $fileName ?? null,  // Save the file name (optional)
            'file_location' => $filePath ?? null,  // Save the file path
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Post inserted successfully!',
            'data' => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the existing post
        $post = MPosts::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'judul_posts' => 'required|string|max:255',
            'id_modul' => 'nullable|exists:m_modul,id',
            'parent_post_id' => 'nullable|exists:t_posts,id',
            'file' => 'nullable|file|mimes:md|max:10240',  // Validation for .md file
        ]);

        // Handle the new file upload (if exists)
        $filePath = $post->file_location; // Keep the old file path
        if ($request->hasFile('file')) {
            // If there's a new file, delete the old one first
            if ($filePath) {
                Storage::disk('public')->delete($filePath);  // Delete the old file
            }

            // Store the new file and get its path
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();  // Ensure unique file name
            $filePath = $file->storeAs('posts', $fileName, 'public');  // Store file and get its path
        }

        // Update the post record
        $post->update([
            'judul_posts' => $validated['judul_posts'],
            'id_modul' => $validated['id_modul'],
            'parent_post_id' => $validated['parent_post_id'],
            'filename' => $fileName ?? $post->filename,  // Update file name if new file is uploaded
            'file_location' => $filePath,  // Update file path
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Post updated successfully!',
            'data' => $post
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = MPosts::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully!'
        ], 200);
    }

    /**
     * Get posts data for DataTables.
     */
    public function getPosts(Request $request)
    {
        if ($request->ajax()) {
            // Eager load the related models, including 'modul' and 'kategori'
            $data = MPosts::with(['modul', 'parentPost', 'creator', 'updater', 'modul.kategori'])
                ->select('id', 'judul_posts', 'id_modul', 'parent_post_id', 'filename', 'file_location', 'created_by', 'updated_by');

            return DataTables::of($data)
                ->addColumn('modul_name', function ($row) {
                    return $row->modul ? $row->modul->nama_modul : 'N/A';
                })
                ->addColumn('kategori_name', function ($row) {
                    // Accessing the 'nama_kategori' from the related 'modul' and 'kategori'
                    return $row->modul && $row->modul->kategori ? $row->modul->kategori->nama_kategori : 'N/A';
                })
                ->addColumn('parent_post', function ($row) {
                    return $row->parentPost ? $row->parentPost->judul_posts : 'N/A';
                })
                ->addColumn('created_by', function ($row) {
                    return $row->creator ? $row->creator->name : 'N/A';
                })
                ->addColumn('updated_by', function ($row) {
                    return $row->updater ? $row->updater->name : 'N/A';
                })
                ->filterColumn('judul_posts', function ($query, $keyword) {
                    $query->where('judul_posts', 'like', "%$keyword%");
                })
                ->make(true);
        }
    }

}
