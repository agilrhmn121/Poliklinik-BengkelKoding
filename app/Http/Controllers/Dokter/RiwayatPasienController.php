<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class RiwayatPasienController extends Controller
{
    public function index()
    {
        $riwayatPasien = Periksa::whereHas('daftarPoli', fn ($query) => $query->where('id_dokter', Auth::id()))
            ->with(['daftarPoli.jadwal.dokter', 'detailPeriksa.obat'])
            ->orderByDesc('tgl_periksa')
            ->get();

        return view('dokter.riwayat-pasien.index', compact('riwayatPasien'));
    }

    public function show(string $id)
    {
        $periksa = Periksa::whereHas('daftarPoli', fn ($query) => $query->where('id_dokter', Auth::id()))
            ->with(['daftarPoli.jadwal.dokter.poli', 'detailPeriksa.obat'])
            ->findOrFail($id);

        return view('dokter.riwayat-pasien.show', compact('periksa'));
    }
}
