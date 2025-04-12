<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    // Menampilkan daftar pengaduan dengan pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Filter berdasarkan search query
        $pengaduan = Pengaduan::where('is_deleted', false) // hanya ambil yang aktif
            ->with(['user', 'kategori'])
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhereHas('kategori', function ($query) use ($search) {
                                 $query->where('nama_kategori', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10);

        return view('pengaduan.index', compact('pengaduan'));
    }

    // Menampilkan form untuk membuat pengaduan
    public function create()
    {
        $kategori = KategoriPengaduan::all();
        return view('pengaduan.create', compact('kategori'));
    }

    // Menyimpan pengaduan baru
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'judul' => 'required',
            'isi' => 'required',
        ]);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Jika tidak ada user, arahkan ke login
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a complaint.');
        }

        // Simpan pengaduan baru
        Pengaduan::create([
            'user_id' => $user->id,
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    // Menghapus pengaduan (soft delete)
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['is_deleted' => true]); // Soft delete menggunakan is_deleted
        return back()->with('success', 'Pengaduan berhasil dihapus (soft delete).');
    }

    // Menghapus pengaduan secara permanen
    public function forceDelete($id)
    {
        $pengaduan = Pengaduan::where('id', $id)->where('is_deleted', true)->first();
        if ($pengaduan) {
            $pengaduan->forceDelete(); // Menghapus data secara permanen
            return back()->with('success', 'Pengaduan dihapus permanen.');
        }
        return back()->with('error', 'Pengaduan tidak ditemukan.');
    }

    // Menampilkan pengaduan yang sudah dihapus (soft delete)
    public function softDeleted()
    {
        // Mengambil semua pengaduan yang soft deleted menggunakan is_deleted
        $pengaduan = Pengaduan::where('is_deleted', true)->with(['user', 'kategori'])->get();

        return view('pengaduan.soft_deleted', compact('pengaduan'));
    }

    // Menampilkan detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'kategori'])->findOrFail($id);
        return view('pengaduan.show', compact('pengaduan'));
    }

    // Menampilkan form untuk mengedit pengaduan
    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $kategori = KategoriPengaduan::all();
        return view('pengaduan.edit', compact('pengaduan', 'kategori'));
    }

    // Memperbarui data pengaduan
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // Menampilkan pengaduan dengan join untuk kategori dan respon
    public function join()
    {
        $data = DB::table('pengaduan')
            ->join('kategori_pengaduan', 'pengaduan.kategori_id', '=', 'kategori_pengaduan.id')
            ->leftJoin('respon_pengaduan', 'pengaduan.id', '=', 'respon_pengaduan.pengaduan_id')
            ->select(
                'pengaduan.id',
                'pengaduan.judul',
                'pengaduan.isi', // ← ini disesuaikan
                'pengaduan.status',
                'pengaduan.created_at',
                'kategori_pengaduan.nama_kategori',
                'respon_pengaduan.isi_respon as respon'
            )
            ->get();
    
        return view('pengaduan.join', compact('data'));
    }
    
    
    

    // Menampilkan pengaduan yang sudah dihapus (soft delete)
public function trash()
{
    // Mengambil semua pengaduan yang soft deleted menggunakan is_deleted = 1
    $pengaduan = Pengaduan::where('is_deleted', true)->with(['user', 'kategori'])->paginate(10);

    return view('pengaduan.trash', compact('pengaduan'));
}

// Mengembalikan pengaduan yang dihapus (soft delete)
public function restore($id)
{
    // Find the soft-deleted complaint (where is_deleted is true)
    $pengaduan = Pengaduan::where('id', $id)->where('is_deleted', true)->firstOrFail();
    
    // Restore the 'is_deleted' field to false (0)
    $pengaduan->update(['is_deleted' => false]);

    return back()->with('success', 'Pengaduan berhasil dipulihkan.');
}



}
