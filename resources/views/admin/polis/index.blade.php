<x-layout.app title="Manajemen Poli">
    <div class="mx-auto max-w-6xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen Poli</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola data poli yang tersedia di klinik.</p>
            </div>
            <a href="{{ route('polis.create') }}" class="rounded-xl bg-indigo-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-800">Tambah Poli</a>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr><th class="px-6 py-4">No</th><th class="px-6 py-4">Nama Poli</th><th class="px-6 py-4">Keterangan</th><th class="px-6 py-4 text-right">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($polis as $poli)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $poli->nama_poli }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $poli->keterangan ?: '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2 whitespace-nowrap">
                                        <a href="{{ route('polis.edit', $poli) }}" class="inline-flex items-center justify-center rounded-lg bg-orange-100 px-3 py-2 text-xs font-semibold text-orange-700 transition hover:bg-orange-200">Edit</a>
                                        <form method="POST" action="{{ route('polis.destroy', $poli) }}" onsubmit="return confirm('Hapus poli ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-200">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-slate-500">Belum ada data poli.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout.app>
