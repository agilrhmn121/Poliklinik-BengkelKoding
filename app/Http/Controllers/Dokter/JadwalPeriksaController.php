<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwals = Auth::user()->jadwalPeriksa()->orderBy('hari')->orderBy('jam_mulai')->get();
        return view('dokter.jadwal-periksa.index', compact('jadwals'));
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        Auth::user()->jadwalPeriksa()->create($data);
        return redirect()->route('jadwal-periksa.index')->with('message', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $jadwal = $this->ownedSchedule($id);
        return view('dokter.jadwal-periksa.edit', compact('jadwal'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        $this->ownedSchedule($id)->update($data);
        return redirect()->route('jadwal-periksa.index')->with('message', 'Jadwal berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $this->ownedSchedule($id)->delete();
        return redirect()->route('jadwal-periksa.index')->with('message', 'Jadwal berhasil dihapus.');
    }

    private function ownedSchedule(int|string $id): JadwalPeriksa
    {
        return Auth::user()->jadwalPeriksa()->whereKey($id)->firstOrFail();
    }
}
