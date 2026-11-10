<x-layout.app title="Pemeriksaan Pasien">
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Pemeriksaan Pasien</h1>
        <p class="mt-1 text-sm text-slate-500">Antrean nomor {{ $daftarPoli->no_antrian }} · {{ $daftarPoli->jadwal?->hari }} {{ $daftarPoli->jadwal ? substr($daftarPoli->jadwal->jam_mulai, 0, 5) : '' }}</p>
        <p class="mt-3 rounded-xl bg-slate-50 p-4 text-sm text-slate-600">Keluhan: {{ $daftarPoli->keluhan }}</p>

        @if($errors->any())<div class="mt-5 rounded-xl bg-red-50 p-4 text-sm text-red-700"><ul class="list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <form method="POST" action="{{ route('periksa-pasien.store') }}" class="mt-6 space-y-5">
            @csrf
            <input type="hidden" name="id_daftar_poli" value="{{ $daftarPoli->id }}">
            <input type="hidden" id="obatJson" name="obat_json" value="[]">
            <div><label for="catatan" class="mb-2 block text-sm font-semibold text-slate-700">Catatan Dokter</label><textarea id="catatan" name="catatan" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm" placeholder="Catatan hasil pemeriksaan">{{ old('catatan') }}</textarea></div>
            <div><label for="biaya_periksa" class="mb-2 block text-sm font-semibold text-slate-700">Biaya Pemeriksaan</label><input id="biaya_periksa" name="biaya_periksa" type="number" min="0" value="{{ old('biaya_periksa', 0) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"><p class="mt-1 text-xs text-slate-500">Sistem menambahkan biaya layanan Rp150.000 sesuai ketentuan controller.</p></div>
            <div><p class="mb-2 text-sm font-semibold text-slate-700">Pilih Obat</p><div class="grid gap-3 sm:grid-cols-2">@forelse($obats as $obat)<label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 hover:bg-slate-50"><input type="checkbox" value="{{ $obat->id }}" class="obat-checkbox rounded border-slate-300 text-indigo-600"><span><span class="block text-sm font-semibold text-slate-800">{{ $obat->nama_obat }}</span><span class="text-xs text-slate-500">{{ $obat->kemasan }} · Rp {{ number_format($obat->harga, 0, ',', '.') }}</span></span></label>@empty<p class="text-sm text-red-600">Belum ada data obat. Tambahkan obat melalui Admin terlebih dahulu.</p>@endforelse</div></div>
            <div class="flex gap-3"><a href="{{ route('periksa-pasien.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600">Batal</a><button type="submit" class="rounded-xl bg-indigo-700 px-4 py-3 text-sm font-semibold text-white">Simpan Pemeriksaan</button></div>
        </form>
    </div>
    @push('scripts')<script>const updateObatJson=()=>{document.getElementById('obatJson').value=JSON.stringify([...document.querySelectorAll('.obat-checkbox:checked')].map(item=>item.value));};document.querySelectorAll('.obat-checkbox').forEach(item=>item.addEventListener('change',updateObatJson));</script>@endpush
</x-layout.app>
