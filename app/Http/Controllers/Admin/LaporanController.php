<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with(['siswa.user', 'kategori'])->latest('id');

        // Filter berdasarkan nama siswa
        if ($request->filled('nama')) {
            $query->whereHas('siswa.user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $data = [
            'title' => 'Data Aspirasi',
            'aspirasi' => $query->paginate(5)->withQueryString(),
            'kategoriList' => \App\Models\Kategori::all(),
        ];

        return view('admin.laporan-aspirasi', $data);
    }

    public function cetak(Request $request)
    {
        $query = Aspirasi::with(['siswa.user', 'kategori'])->latest('id');

        // Filter berdasarkan nama siswa
        if ($request->filled('nama')) {
            $query->whereHas('siswa.user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $aspirasi = $query->get(); // TANPA paginate

        $pdf = Pdf::loadView('admin.cetak-laporan', ['aspirasi' => $aspirasi]);
        return $pdf->stream();
    }
}
