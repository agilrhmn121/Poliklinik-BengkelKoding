<x-layout.guest title="Register - Poliklinik">
    <div class="w-full max-w-2xl rounded-3xl bg-white p-8 shadow-2xl shadow-slate-950/20 sm:p-10">
        <div class="mb-8">
            <p class="text-sm font-semibold text-indigo-600">Poliklinik</p>
            <h1 class="mt-2 text-2xl font-extrabold text-slate-900">Buat akun pasien</h1>
            <p class="mt-2 text-sm text-slate-500">Lengkapi data berikut untuk mendaftar sebagai pasien.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.process') }}" class="grid gap-5 sm:grid-cols-2">
            @csrf
            <div class="sm:col-span-2">
                <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                <input id="nama" name="nama" value="{{ old('nama') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div class="sm:col-span-2">
                <label for="alamat" class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
                <input id="alamat" name="alamat" value="{{ old('alamat') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div>
                <label for="no_ktp" class="mb-2 block text-sm font-semibold text-slate-700">Nomor KTP</label>
                <input id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div>
                <label for="no_hp" class="mb-2 block text-sm font-semibold text-slate-700">Nomor HP</label>
                <input id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div>
                <label for="id_poli" class="mb-2 block text-sm font-semibold text-slate-700">Poli</label>
                <select id="id_poli" name="id_poli" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    <option value="">Pilih poli</option>
                    @foreach ($polis as $poli)
                        <option value="{{ $poli->id }}" @selected(old('id_poli') == $poli->id)>{{ $poli->nama_poli }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required minlength="8" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
            <div class="sm:col-span-2 mt-2">
                <button type="submit" class="w-full rounded-xl bg-indigo-700 px-4 py-3.5 text-sm font-bold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-200">Daftar sebagai pasien</button>
                <p class="mt-4 text-center text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-indigo-700 hover:text-indigo-900">Masuk</a></p>
            </div>
        </form>
    </div>
</x-layout.guest>
