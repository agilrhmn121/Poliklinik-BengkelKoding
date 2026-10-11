<x-layout.guest title="Login - Poliklinik">
    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl shadow-slate-950/20 sm:p-10">
        <div class="mb-8 text-center">
            <img src="{{ asset('images/logo-bengkot.png') }}" alt="Logo Poliklinik" class="mx-auto h-14 w-14 rounded-2xl object-cover shadow-sm">
            <h1 class="mt-5 text-2xl font-extrabold text-slate-900">Masuk ke Poliklinik</h1>
            <p class="mt-2 text-sm text-slate-500">Gunakan akun yang sudah terdaftar</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="nama@email.com">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Masukkan password">
            </div>
            <button type="submit" class="w-full rounded-xl bg-indigo-700 px-4 py-3.5 text-sm font-bold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-200">Masuk</button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-700 hover:text-indigo-900">Daftar sekarang</a>
        </p>
    </div>
</x-layout.guest>
