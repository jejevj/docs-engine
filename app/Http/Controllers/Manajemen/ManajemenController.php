<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Manajemen\MKategori;
use Illuminate\Http\Request;

class ManajemenController extends Controller
{
    public function index()
    {
        $kategoris = MKategori::get();
        // dump($kategoris);
        return view('manajemen.index', ['kategoris' => $kategoris]);
    }
}
