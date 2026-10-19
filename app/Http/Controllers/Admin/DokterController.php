<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')->with('poli')->orderBy('id')->get();

        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.dokter.create', compact('polis'));
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

        User::create([
            ...$data,
            'no_rm' => 'DOK-' . str_pad((string) (User::where('role', 'dokter')->count() + 1), 4, '0', STR_PAD_LEFT),
            'role' => 'dokter',
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('dokter.index')->with('message', 'Data dokter berhasil ditambahkan.')->with('type', 'success');
    }

    public function edit(User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp,' . $dokter->id],
            'no_hp' => ['required', 'string', 'max:15'],
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $dokter->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $dokter->update($data);

        return redirect()->route('dokter.index')->with('message', 'Data dokter berhasil diubah.')->with('type', 'success');
    }

    public function destroy(User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);
        $dokter->delete();

        return redirect()->route('dokter.index')->with('message', 'Data dokter berhasil dihapus.')->with('type', 'success');
    }
}
