<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Manajemen\MPosts;
use App\Models\Manajemen\MModul;
use Illuminate\Http\Request;
use Log;
use Yajra\DataTables\DataTables;
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
            'deskripsi' => 'required|string',
            'id_modul' => 'nullable|exists:m_modul,id',  // Ensure id_modul exists in m_modul
            'parent_post_id' => 'nullable|exists:t_posts,id',
            'file' => 'nullable|file|mimes:md|max:10240',  // Validation for .md file
            'content' => 'required|string', // Validation for the markdown content
        ]);

        // Retrieve the module (modul_slug) and category (kategori_slug) using the id_modul
        $modul = MModul::findOrFail($validated['id_modul']);
        $kategori_name = $modul->kategori->nama_kategori;
        $modul_name = $modul->nama_modul;
        $kategori_slug = strtolower(str_replace(' ', '-', $modul->kategori->nama_kategori));  // Assuming 'nama_kategori' is the category name
        $modul_slug = strtolower(str_replace(' ', '', $modul->nama_modul));  // Assuming 'nama_modul' is the module name

        // Create the metadata for the markdown file
        $metadata = "---\n"; 
        $metadata .= "title: " . $validated['judul_posts'] . "\n";
        $metadata .= "description: " . (string)$validated['deskripsi'] . "\n";
        $metadata .= "---\n\n";  // End of metadata, and add a blank line

        // Combine the metadata with the content
        $finalContent = $metadata . $validated['content'];

        // Create a unique filename for the markdown file
        $fileName = strtolower(str_replace(' ', '-', $validated['judul_posts'])) . '.md';  // Use 'judul_posts' as the filename

        // Define the file path with the required directory structure
        $filePath = 'content/docs/' . $kategori_slug . '/' . $modul_slug . '/' . $fileName;

        // Store the markdown content as a .md file in the 'public' disk under the created path
        Storage::disk('public')->put($filePath, $finalContent);

        // Handle file upload (optional)
        $filePathFromUpload = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileNameFromUpload = time() . '_' . $file->getClientOriginalName();
            $filePathFromUpload = $file->storeAs('posts', $fileNameFromUpload, 'public');
        }

        // Create the new post record with the markdown file path
        $post = MPosts::create([
            'judul_posts' => $validated['judul_posts'],
            'deskripsi' => $validated['deskripsi'],
            'id_modul' => $validated['id_modul'],
            'parent_post_id' => $validated['parent_post_id'] ?? null,
            'filename' => $fileName,  // Save the markdown file name
            'file_location' => $filePath ?? $filePathFromUpload,  // Save the file path
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Update the sidebar JSON file
        $this->updateSidebarJson($kategori_name, $modul_name, $modul_slug, $kategori_slug);

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
            'deskripsi' => 'required|string|max:255',
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
            'deskripsi' => $validated['deskripsi'],
            'id_modul' => $validated['id_modul'],
            'parent_post_id' => $validated['parent_post_id'] ?? null,
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
                ->select('id', 'judul_posts', 'deskripsi', 'id_modul', 'parent_post_id', 'filename', 'file_location', 'created_by', 'updated_by');

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


    public function updateSidebarJson($kategori_name, $modul_name, $modul_slug, $kategori_slug)
    {
        // Path to the sidebar.json file
        $sidebarJsonPath = storage_path('app/public/content/config/sidebar.json');

        // Read the existing sidebar JSON file
        if (file_exists($sidebarJsonPath)) {
            $sidebarJson = json_decode(file_get_contents($sidebarJsonPath), true);

            // Check if the category already exists
            $categoryExists = false;
            $moduleExists = false;
            foreach ($sidebarJson['main'] as &$category) {
                if (strtolower($category['label']) == strtolower($kategori_name)) {
                    $categoryExists = true;
                    // Check if the module exists within the category
                    foreach ($category['items'] as &$item) {
                        if (isset($item['autogenerate']['directory']) && strpos($item['autogenerate']['directory'], $modul_slug) !== false) {
                            $moduleExists = true;
                            break;
                        }
                    }
                    // If the module doesn't exist, add it
                    if (!$moduleExists) {
                        $category['items'][] = [
                            'label' => "[icon] $modul_name",
                            'autogenerate' => [
                                'directory' => "$kategori_slug/$modul_slug"
                            ]
                        ];
                    }
                    break;
                }
            }

            // If the category doesn't exist, create it
            if (!$categoryExists) {
                $sidebarJson['main'][] = [
                    'label' => $kategori_name,
                    'items' => [
                        [
                            'label' => "[icon] $modul_name",
                            'autogenerate' => [
                                'directory' => "$kategori_slug/$modul_slug"
                            ]
                        ]
                    ]
                ];
            }

            // Save the updated sidebar back to the JSON file
            file_put_contents($sidebarJsonPath, json_encode($sidebarJson, JSON_PRETTY_PRINT));
        } else {
            // If the file doesn't exist, create a new structure
            $newSidebarJson = [
                'main' => [
                    [
                        'label' => $kategori_name,
                        'items' => [
                            [
                                'label' => "[icon] $modul_name",
                                'autogenerate' => [
                                    'directory' => "$kategori_slug/$modul_slug"
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            // Save the new sidebar.json file
            file_put_contents($sidebarJsonPath, json_encode($newSidebarJson, JSON_PRETTY_PRINT));
        }
    }

}
