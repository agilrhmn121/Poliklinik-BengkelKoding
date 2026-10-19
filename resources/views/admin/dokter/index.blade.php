<x-layout.app title="Manajemen Dokter">
    <div class="mx-auto max-w-6xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div><h1 class="text-2xl font-bold text-slate-900">Manajemen Dokter</h1><p class="mt-1 text-sm text-slate-500">Kelola data dokter dan poli tempat praktik.</p></div>
            <a href="{{ route('dokter.create') }}" class="rounded-xl bg-indigo-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-800">Tambah Dokter</a>
        </div>
        @if(session('message'))<div class="mb-5 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('message') }}</div>@endif
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto"><table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">No</th><th class="px-6 py-4">Dokter</th><th class="px-6 py-4">Kontak</th><th class="px-6 py-4">Poli</th><th class="px-6 py-4 text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dokters as $dokter)
                        <tr class="hover:bg-slate-50"><td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td><td class="px-6 py-4"><p class="font-semibold text-slate-900">{{ $dokter->nama }}</p><p class="text-xs text-slate-500">{{ $dokter->email }}</p></td><td class="px-6 py-4 text-slate-600">{{ $dokter->no_hp }}<br><span class="text-xs">KTP: {{ $dokter->no_ktp }}</span></td><td class="px-6 py-4 text-slate-600">{{ $dokter->poli?->nama_poli ?? '-' }}</td><td class="px-6 py-4"><div class="flex justify-end gap-2 whitespace-nowrap"><a href="{{ route('dokter.edit', $dokter) }}" class="inline-flex items-center rounded-lg bg-orange-100 px-3 py-2 text-xs font-semibold text-orange-700 hover:bg-orange-200">Edit</a><form method="POST" action="{{ route('dokter.destroy', $dokter) }}" onsubmit="return confirm('Hapus dokter ini?')">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">Hapus</button></form></div></td></tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada data dokter.</td></tr>
                    @endforelse
                </tbody>
            </table></div>
        </div>
    </div>
</x-layout.app>
