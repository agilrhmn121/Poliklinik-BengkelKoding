@if ($errors->any())
    <div class="rounded-xl bg-red-50 p-4 text-sm text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<div>
    <label for="nama_poli" class="mb-2 block text-sm font-semibold text-slate-700">Nama Poli</label>
    <input id="nama_poli" name="nama_poli" value="{{ old('nama_poli', $poli->nama_poli ?? '') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
</div>
<div>
    <label for="keterangan" class="mb-2 block text-sm font-semibold text-slate-700">Keterangan</label>
    <textarea id="keterangan" name="keterangan" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">{{ old('keterangan', $poli->keterangan ?? '') }}</textarea>
</div>
