<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResponPengaduan;
use App\Models\Pengaduan;

class ResponPengaduanController extends Controller
{
    public function store(Request $request, $pengaduan_id)
{
    $request->validate([
        'isi_respon' => 'required',
    ]);

    // Ensure the user is authenticated
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login')->with('error', 'You must be logged in to respond.');
    }

    // Create the response to the complaint
    ResponPengaduan::create([
        'pengaduan_id' => $pengaduan_id,
        'user_id' => $user->id,  // Access user ID via auth()
        'isi_respon' => $request->isi_respon,
    ]);

    // Update the complaint status to 'diproses'
    Pengaduan::where('id', $pengaduan_id)->update(['status' => 'diproses']);

    return back()->with('success', 'Respon berhasil ditambahkan.');
}

}
