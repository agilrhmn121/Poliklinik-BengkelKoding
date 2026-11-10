<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    public function get()
    {
        $user = Auth::user();
        $polis = Poli::orderBy('nama_poli')->get();
        $jadwals = JadwalPeriksa::with('dokter.poli')
            ->whereHas('dokter', fn ($query) => $query->where('role', 'dokter'))
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('pasien.daftar', compact('user', 'polis', 'jadwals'));
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'id_jadwal' => ['required', 'integer', 'exists:jadwal_periksa,id'],
            'keluhan' => ['nullable', 'string'],
        ]);

        $jadwal = JadwalPeriksa::with('dokter')->findOrFail($data['id_jadwal']);
        abort_unless($jadwal->dokter && $jadwal->dokter->id_poli === (int) $data['id_poli'], 422);

        $noAntrian = DaftarPoli::where('id_jadwal', $jadwal->id)->count() + 1;

        DaftarPoli::create([
            'id_dokter' => $jadwal->id_dokter,
            'id_jadwal' => $jadwal->id,
            'keluhan' => $data['keluhan'] ?? '-',
            'no_antrian' => $noAntrian,
        ]);

        return back()->with('message', 'Berhasil mendaftar ke poli. Nomor antrean Anda: ' . $noAntrian);
    }
}
