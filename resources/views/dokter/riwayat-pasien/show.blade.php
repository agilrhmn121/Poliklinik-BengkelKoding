<x-layout.app title="Detail Riwayat Pasien">
    <div class="mx-auto max-w-5xl">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('riwayat-pasien.index') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-slate-200">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <h2 class="text-2xl font-bold text-slate-800">Detail Riwayat</h2>
        </div>

        <div class="flex w-full flex-col gap-5">
            <section class="card rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="card-body p-0">
                    <div class="border-b border-slate-200 px-6 py-4"><h3 class="font-bold text-slate-800">Informasi Pendaftaran</h3></div>
                    <div class="flex flex-col gap-3 px-6 py-5 text-sm">
                        <div class="flex gap-2"><span class="w-40 font-medium text-slate-500">Nomor Antrean</span><span class="font-semibold text-slate-800">{{ $periksa->daftarPoli?->no_antrian ?? '-' }}</span></div>
                        <div class="flex gap-2"><span class="w-40 font-medium text-slate-500">Keluhan</span><span class="text-slate-800">{{ $periksa->daftarPoli?->keluhan ?? '-' }}</span></div>
                        <div class="flex gap-2"><span class="w-40 font-medium text-slate-500">Poli</span><span class="text-slate-800">{{ $periksa->daftarPoli?->jadwal?->dokter?->poli?->nama_poli ?? '-' }}</span></div>
                        <div class="flex gap-2"><span class="w-40 font-medium text-slate-500">Dokter</span><span class="text-slate-800">{{ $periksa->daftarPoli?->jadwal?->dokter?->nama ?? '-' }}</span></div>
                        <div class="flex gap-2"><span class="w-40 font-medium text-slate-500">Jadwal</span><span class="text-slate-800">{{ $periksa->daftarPoli?->jadwal?->hari ?? '-' }} · {{ $periksa->daftarPoli?->jadwal ? substr($periksa->daftarPoli->jadwal->jam_mulai, 0, 5) . ' - ' . substr($periksa->daftarPoli->jadwal->jam_selesai, 0, 5) : '-' }}</span></div>
                        <div class="flex gap-2"><span class="w-40 font-medium text-slate-500">Tanggal Periksa</span><span class="text-slate-800">{{ $periksa->tgl_periksa?->format('d/m/Y H:i') ?? '-' }}</span></div>
                    </div>
                </div>
            </section>

            <section class="card rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="card-body p-0">
                    <div class="border-b border-slate-200 px-6 py-4"><h3 class="font-bold text-slate-800">Catatan Dokter</h3></div>
                    <div class="whitespace-pre-line px-6 py-5 text-sm text-slate-600">{{ $periksa->catatan ?: 'Tidak ada catatan' }}</div>
                </div>
            </section>

            <section class="card rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="card-body p-0">
                    <div class="border-b border-slate-200 px-6 py-4"><h3 class="font-bold text-slate-800">Obat yang Diresepkan</h3></div>
                    @if($periksa->detailPeriksa->isNotEmpty())
                        <div class="overflow-x-auto"><table class="table table-zebra w-full"><thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">#</th><th class="px-6 py-4">Nama Obat</th><th class="px-6 py-4">Kemasan</th><th class="px-6 py-4">Harga</th></tr></thead><tbody>@foreach($periksa->detailPeriksa as $index => $detail)<tr class="transition hover:bg-slate-50"><td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td><td class="px-6 py-4 font-semibold text-slate-800">{{ $detail->obat?->nama_obat ?? '-' }}</td><td class="px-6 py-4 text-slate-500">{{ $detail->obat?->kemasan ?? '-' }}</td><td class="px-6 py-4 text-slate-500">Rp {{ number_format($detail->obat?->harga ?? 0, 0, ',', '.') }}</td></tr>@endforeach</tbody></table></div>
                    @else
                        <div class="px-6 py-5 text-sm text-slate-400">Tidak ada obat yang diresepkan.</div>
                    @endif
                </div>
            </section>

            <section class="card rounded-2xl border border-slate-200 bg-base-100 shadow-sm">
                <div class="card-body flex-row items-center justify-between px-6 py-5"><span class="font-bold text-slate-700">Total Biaya Periksa</span><span class="text-2xl font-bold text-[#2d4499]">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</span></div>
            </section>
        </div>
    </div>
</x-layout.app>
