<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aspirasi;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TanggapanAspirasiService;

class AspirasiController extends Controller
{
    public function __construct(
        private TanggapanAspirasiService $service
    ) {}

    public function index()
    {
        $data = [
            'title' => 'Data Aspirasi',
            'aspirasi' => Aspirasi::with('siswa.user', 'kategori')->latest('id')->paginate(5),
        ];

        return view('admin.data-aspirasi', $data);
    }

    public function getTanggapanByAspirasi(Request $request)
    {
        $tanggapan = Tanggapan::where([
            'aspirasi_id' =>  $request->id,
            'user_id' => $request->userId
        ])->first();
        $aspirasi = Aspirasi::find($request->id);

        $data = [
            'aspirasi' => $aspirasi,
            'tanggapan' => $tanggapan,
        ];

        return $data;
    }

    public function addTanggapan(Request $request)
    {
        try {
            $this->service->addTanggapan($request->all());
            return redirect()->route('admin.aspirasi')->with('success', 'Tanggapan berhasil ditambahkan ke dalam database, dan status aspirasi berhasil  di-update.');
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->route('admin.aspirasi')->with('error', 'Gagal menambahkan data tanggapan!');
        }
    }

    public function delete(Aspirasi $aspirasi)
    {
        try {
            $this->service->delete($aspirasi);
            return redirect()->route('admin.aspirasi')->with('success', 'Aspirasi berhasil dihapus dalam database!');
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->route('admin.aspirasi')->with('error', 'Gagal menghapus data Aspirasi!');
        }
    }
}
