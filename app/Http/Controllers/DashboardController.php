<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\ResponPengaduan;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Menghitung pengaduan yang belum dihapus
        $totalPengaduan = Pengaduan::where('is_deleted', false)->count();
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->where('is_deleted', false)->count();
        $pengaduanDiproses = Pengaduan::where('status', 'diproses')->where('is_deleted', false)->count();
        $pengaduanTerbaru = Pengaduan::with('user')->where('is_deleted', false)->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalPengaduan', 
            'pengaduanSelesai', 
            'pengaduanDiproses', 
            'pengaduanTerbaru'
        ));
    } else {
        // Untuk pengguna biasa, hanya tampilkan pengaduan yang tidak dihapus
        $pengaduanSaya = Pengaduan::where('user_id', $user->id)->where('is_deleted', false)->count();
        $pengaduanSelesai = Pengaduan::where('user_id', $user->id)->where('status', 'selesai')->where('is_deleted', false)->count();

        return view('dashboard', compact('pengaduanSaya', 'pengaduanSelesai'));
    }
}

}
