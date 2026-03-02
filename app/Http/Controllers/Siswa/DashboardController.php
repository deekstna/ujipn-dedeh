<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Services\TanggapanAspirasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private TanggapanAspirasiService $service
    ){}

    public function index()
    {
        $siswa_id = Auth::user()->siswa->id;
        $data =[
            'aspirasi' => Aspirasi::where('siswa_id', $siswa_id)->paginate(4),
            'total_aspirasi' => Aspirasi::where('siswa_id', $siswa_id)->get()->count(),
            'aspirasi_menunggu' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'menunggu'
            ])->get()->count(),
            'aspirasi_diproses' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'diproses',
            ])->get()->count(),
            'aspirasi_selesai' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'selesai'
            ])->get()->count(),
            'aspirasi_ditolak' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'ditolak'
            ])->get()->count(),
        ];

        return view('siswa.dashboard', $data);
    }

    public function tambahAspirasi()
    {
        $data = [
            'kategori' => Kategori::all(),
        ];

        return view('siswa.form-aspirasi', $data);
    }

    public function simpanAspirasi(Request $request)
    {
        $validatedData = $request->validate ([
            'siswa_id' => 'required',
            'kategori_id' => 'required',
            'judul' => 'required',
            'isi' => 'required',
        ], [
            'siswa_id' => 'Id siswa tidak ditemukan',
            'kategori_id' => 'Kategori harus dipilih',
            'judul' => 'Judul harus diisi!',
            'isi' => 'Isi pesan/aduan harus diisi',
        ]);


        $validatedData['status'] = 'menunggu';

        Aspirasi::create($validatedData);
        return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil  ditambahkan!');
    }

    public function editAspirasi(Aspirasi $aspirasi)
    {
        $data = [
            'aspirasi' => $aspirasi,
            'kategori' => Kategori::all(),
        ];

        return view('siswa.form-edit-aspirasi', $data);
    }

    public function updateAspirasi(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required',
            'isi' => 'required',
        ], [
            'kategori_id' => 'Kategori harus dipilih',
            'judul' => 'Judul harus diisi!',
            'isi' => 'Isi pesan/aduan harus diisi',
        ]);

        $aspirasi = Aspirasi::find($request->id);
        $aspirasi->update($validatedData);
        return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil  di-update!');
    }

    public function hapusAspirasi(Aspirasi $aspirasi)
    {
        try {
            $this->service->delete($aspirasi);
            return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil dihapus dari databasse.');
        } catch(\Throwable $e) {
            return redirect()->route('siswa.dashboard')->with('error', 'Gagal menghapus aspirasi');
        }
    }

}
