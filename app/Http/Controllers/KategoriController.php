<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategories = KategoriPengaduan::latest()->get();
        return view('kategori.index', compact('kategories'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_pengaduan,nama_kategori',
        ]);

        KategoriPengaduan::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
}
