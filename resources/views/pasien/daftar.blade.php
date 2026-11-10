<x-layout.app title="Daftar Poli">
    <div class="flex items-center justify-center px-4">
        <div class="w-full max-w-3xl">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="mb-6 text-center text-2xl font-bold">🏥 Pendaftaran Poli</h2>

                    @if (session('message'))
                        <div id="toastSuccess" class="toast toast-top toast-end z-50">
                            <div class="alert alert-success shadow-lg"><span>{{ session('message') }}</span></div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="mb-1 block font-semibold">Nomor Rekam Medis</label>
                            <input type="text" value="{{ $user->no_rm }}" class="w-full rounded-lg border-2 bg-gray-100 p-2" disabled>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block font-semibold">Pilih Poli</label>
                            <select name="id_poli" id="poliSelect" required class="w-full rounded-lg border-2 p-2">
                                <option value="">-- Pilih Poli --</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}" @selected(old('id_poli') == $poli->id)>{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block font-semibold">Pilih Jadwal Periksa</label>
                            <select name="id_jadwal" id="jadwalSelect" required class="w-full rounded-lg border-2 p-2">
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach ($jadwals as $jadwal)
                                    <option value="{{ $jadwal->id }}" data-poli="{{ $jadwal->dokter?->id_poli }}" @selected(old('id_jadwal') == $jadwal->id)>
                                        {{ $jadwal->hari }} {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} · Dr. {{ $jadwal->dokter?->nama ?? '--' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="mb-1 block font-semibold">Keluhan</label>
                            <textarea name="keluhan" rows="3" class="w-full rounded-lg border-2 p-2" placeholder="Tulis keluhan anda...">{{ old('keluhan') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-8 py-2 font-semibold text-white transition hover:bg-blue-700">Daftar Poli</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const poliSelect = document.getElementById('poliSelect');
                const jadwalSelect = document.getElementById('jadwalSelect');
                const jadwalOptions = jadwalSelect.querySelectorAll('option');

                const filterJadwal = () => {
                    const poliId = poliSelect.value;
                    jadwalOptions.forEach((option) => {
                        if (option.value === '') return;
                        option.hidden = Boolean(poliId) && option.dataset.poli !== poliId;
                    });
                    if (jadwalSelect.selectedOptions[0]?.hidden) jadwalSelect.value = '';
                };

                poliSelect.addEventListener('change', filterJadwal);
                filterJadwal();
            });
        </script>
    @endpush
</x-layout.app>
