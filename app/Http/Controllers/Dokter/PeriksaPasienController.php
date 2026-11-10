<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $daftarPasien = DaftarPoli::with(['jadwal', 'periksa'])
            ->where('id_dokter', Auth::id())
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create(string $id)
    {
        $daftarPoli = $this->ownedRegistration($id);
        abort_if($daftarPoli->periksa()->exists(), 422, 'Pendaftaran ini sudah diperiksa.');

        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.periksa-pasien.create', compact('obats', 'daftarPoli'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_daftar_poli' => ['required', 'integer', 'exists:daftar_poli,id'],
            'obat_json' => ['required', 'json'],
            'catatan' => ['nullable', 'string'],
            'biaya_periksa' => ['required', 'integer', 'min:0'],
        ]);

        $daftarPoli = $this->ownedRegistration($data['id_daftar_poli']);
        abort_if($daftarPoli->periksa()->exists(), 422, 'Pendaftaran ini sudah diperiksa.');

        $decodedObatIds = json_decode($data['obat_json'], true);
        $obatIds = is_array($decodedObatIds)
            ? array_values(array_unique(array_map('intval', $decodedObatIds)))
            : [];

        abort_if(empty($obatIds) || Obat::whereIn('id', $obatIds)->count() !== count($obatIds), 422, 'Pilih minimal satu obat yang valid.');

        DB::transaction(function () use ($data, $daftarPoli, $obatIds) {
            $periksa = Periksa::create([
                'id_daftar_poli' => $daftarPoli->id,
                'tgl_periksa' => now(),
                'catatan' => $data['catatan'] ?? '-',
                'biaya_periksa' => $data['biaya_periksa'] + 150000,
            ]);

            foreach ($obatIds as $idObat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ]);
            }
        });

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil disimpan.');
    }

    private function ownedRegistration(int|string $id): DaftarPoli
    {
        return DaftarPoli::where('id_dokter', Auth::id())->findOrFail($id);
    }
}
