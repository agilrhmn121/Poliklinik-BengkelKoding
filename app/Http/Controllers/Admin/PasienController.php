<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = User::where('role', 'pasien')->with('poli')->orderBy('id')->get();

        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.pasien.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp'],
            'no_hp' => ['required', 'string', 'max:15'],
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $lastPasien = User::where('role', 'pasien')->orderByDesc('id')->first();
        $lastId = $lastPasien ? $lastPasien->id + 1 : 1;

        User::create([
            ...$data,
            'no_rm' => now()->format('Ym') . '-' . str_pad($lastId, 3, '0', STR_PAD_LEFT),
            'role' => 'pasien',
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('pasien.index')->with('message', 'Data pasien berhasil ditambahkan.')->with('type', 'success');
    }

    public function edit(User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.pasien.edit', compact('pasien', 'polis'));
    }

    public function update(Request $request, User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp,' . $pasien->id],
            'no_hp' => ['required', 'string', 'max:15'],
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $pasien->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $pasien->update($data);

        return redirect()->route('pasien.index')->with('message', 'Data pasien berhasil diubah.')->with('type', 'success');
    }

    public function destroy(User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);
        $pasien->delete();

        return redirect()->route('pasien.index')->with('message', 'Data pasien berhasil dihapus.')->with('type', 'success');
    }
}
