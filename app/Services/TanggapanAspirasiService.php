<?php

namespace App\Services;

use App\Models\Aspirasi;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\DB;

class TanggapanAspirasiService
{
    public function addTanggapan(array $data)
    {
        return DB::transaction(function () use ($data){
            $tanggapan = Tanggapan::where([
                'aspirasi_id' => $data['aspirasi_id'],
                'user_id' => $data['user_id'],
            ])->first();

            if(!empty($tanggapan)){
                $tanggapan->update([
                    'isi_tanggapan' => $data['isi_tanggapan']
                ]);
            } else {
                Tanggapan::create([
                    'user_id' => $data['user_id'],
                    'aspirasi_id' => $data['aspirasi_id'],
                    'isi_tanggapan' => $data['isi_tanggapan'],
                ]);
            }

            // Ubah status aspirasi
            $aspirasi = Aspirasi::find($data['aspirasi_id']);
            $aspirasi->update(['status'=> $data['status']]);

        });
    }

    public function delete(Aspirasi $aspirasi)
    {
        $tanggapan = $aspirasi->tanggapan;
        if ($tanggapan->count() > 0) {
            foreach($tanggapan as $item){
                $item->delete();
            }
        }

        $aspirasi->delete();
    }
}
