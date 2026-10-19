<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('id')->get();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kemasan' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        Obat::create($data);
        return redirect()->route('obat.index')->with('message', 'Data obat berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kemasan' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        Obat::findOrFail($id)->update($data);
        return redirect()->route('obat.index')->with('message', 'Data obat berhasil diubah.');
    }

    public function destroy(string $id)
    {
        Obat::findOrFail($id)->delete();
        return redirect()->route('obat.index')->with('message', 'Data obat berhasil dihapus.');
    }
}
