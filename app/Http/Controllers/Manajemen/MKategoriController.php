<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Manajemen\MKategori;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MKategoriController extends Controller
{

    /**
     * Register index.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:m_kategori,nama_kategori',
        ]);

        $kategori = MKategori::create([
            'nama_kategori' => $request->nama_kategori,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('manajemen.index')->with('success', 'Kategori created successfully.');
    }

    public function update(Request $request, $id)
    {   
        $kategori = MKategori::findOrFail($id);
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);
        $kategori->update([
            'nama_kategori' => $validated['nama_kategori'],
            'updated_by' => Auth::id(),  
        ]);
        return response()->json([
            'message' => 'Category updated successfully!',
            'data' => $kategori
        ], 200);
    }
    /**
     * 
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = MKategori::findOrFail($id);
        $kategori->delete();
        return response()->json([
            'message' => 'Kategori deleted successfully!'
        ], 200);
    }

    public function getKategori(Request $request)
    {
        if ($request->ajax()) {
            $data = MKategori::with(['creator', 'updater'])
                ->select('id', 'nama_kategori', 'created_by');
            return DataTables::of($data)
                ->addColumn('created_by', function ($row) {
                    return $row->creator ? $row->creator->name : 'N/A';
                })
                ->filterColumn('nama_kategori', function ($query, $keyword) {
                    $query->where('nama_kategori', 'like', "%$keyword%");
                })
                ->make(true);
        }
    }
}