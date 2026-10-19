<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class AdminPoliController extends Controller
{
    public function index()
    {
        $polis = Poli::orderBy('id')->get();

        return view('admin.polis.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Poli::create($validated);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $poli = Poli::findOrFail($id);

        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_poli' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Poli::findOrFail($id)->update($validated);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Poli::findOrFail($id)->delete();

        return redirect()->route('polis.index')->with('success', 'Poli berhasil dihapus.');
    }
}
