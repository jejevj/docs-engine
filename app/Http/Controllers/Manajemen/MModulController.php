<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Manajemen\MModul;
use App\Models\Manajemen\MKategori;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MModulController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'id_kategori' => 'nullable|exists:m_kategori,id',
        ]);

        $modul = MModul::create([
            'nama_modul' => $request->nama_modul,
            'id_kategori' => $request->id_kategori,
            'nama_kategori' => $request->id_kategori ? MKategori::find($request->id_kategori)->nama_kategori : null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Modul inserted successfully!',
            'data' => $modul
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $modul = MModul::findOrFail($id);
        $validated = $request->validate([
            'nama_modul' => 'required|string|max:255',
            'id_kategori' => 'nullable|exists:m_kategori,id',
        ]);

        $modul->update([
            'nama_modul' => $validated['nama_modul'],
            'id_kategori' => $request->id_kategori,
            'nama_kategori' => $request->id_kategori ? MKategori::find($request->id_kategori)->nama_kategori : null,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Modul updated successfully!',
            'data' => $modul
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $modul = MModul::findOrFail($id);
        $modul->delete();

        return response()->json([
            'message' => 'Modul deleted successfully!'
        ], 200);
    }

    /**
     * Get modules data for DataTables.
     */
    public function getModul(Request $request)
    {
        if ($request->ajax()) {
            $data = MModul::with(['kategori', 'creator', 'updater'])
                ->select('id', 'nama_modul', 'id_kategori', 'created_by', 'updated_by');

            return DataTables::of($data)
                ->addColumn('kategori_name', function ($row) {
                    return $row->kategori ? $row->kategori->nama_kategori : $row->nama_kategori;
                })
                ->addColumn('created_by', function ($row) {
                    return $row->creator ? $row->creator->name : 'N/A';
                })
                ->addColumn('updated_by', function ($row) {
                    return $row->updater ? $row->updater->name : 'N/A';
                })
                ->filterColumn('nama_modul', function ($query, $keyword) {
                    $query->where('nama_modul', 'like', "%$keyword%");
                })
                ->make(true);
        }
    }
}