<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Poliklinik</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 font-sans text-slate-800">
        <div class="flex min-h-screen">
            <aside class="hidden w-64 shrink-0 bg-teal-950 px-5 py-7 text-white lg:block">
                <div class="mb-10 flex items-center gap-3 px-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-400 text-xl font-extrabold text-teal-950">+</div>
                    <div>
                        <p class="text-lg font-extrabold tracking-tight">Poliklinik</p>
                        <p class="text-xs text-teal-200">Sistem Informasi Klinik</p>
                    </div>
                </div>
                <nav class="space-y-2 text-sm">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-xl bg-teal-800 px-4 py-3 font-semibold text-white">Dashboard</a>
                    <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-teal-100 transition hover:bg-teal-900">Data Pasien</a>
                    <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-teal-100 transition hover:bg-teal-900">Jadwal Dokter</a>
                    <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-teal-100 transition hover:bg-teal-900">Pendaftaran</a>
                    <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-teal-100 transition hover:bg-teal-900">Data Obat</a>
                </nav>
            </aside>

            <main class="flex-1">
                <header class="border-b border-slate-200 bg-white px-6 py-5 sm:px-10">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-teal-600">{{ now()->translatedFormat('l, d F Y') }}</p>
                            <h1 class="mt-1 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Dashboard Poliklinik</h1>
                        </div>
                        <div class="hidden items-center gap-3 sm:flex">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900">Admin Klinik</p>
                                <p class="text-xs text-slate-500">Administrator</p>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-100 font-bold text-teal-700">AK</div>
                        </div>
                    </div>
                </header>

                <div class="px-6 py-8 sm:px-10">
                    <section class="mb-8 rounded-2xl bg-gradient-to-r from-teal-700 to-cyan-600 p-6 text-white shadow-lg shadow-teal-900/10 sm:p-8">
                        <p class="mb-2 text-sm font-medium text-teal-100">Selamat datang di sistem klinik</p>
                        <h2 class="text-2xl font-extrabold sm:text-3xl">Kelola layanan kesehatan dengan lebih mudah.</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-teal-50">Pantau pasien, jadwal dokter, pendaftaran, pemeriksaan, dan persediaan obat dari satu dashboard.</p>
                    </section>

                    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-sm font-medium text-slate-500">Total Pasien & Dokter</p>
                            <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ \App\Models\User::count() }}</p>
                            <p class="mt-2 text-xs text-slate-500">Data pengguna terdaftar</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-sm font-medium text-slate-500">Poli</p>
                            <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ \App\Models\Poli::count() }}</p>
                            <p class="mt-2 text-xs text-slate-500">Poli yang tersedia</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-sm font-medium text-slate-500">Jadwal Dokter</p>
                            <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ \App\Models\JadwalPeriksa::count() }}</p>
                            <p class="mt-2 text-xs text-slate-500">Jadwal aktif</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-sm font-medium text-slate-500">Pendaftaran</p>
                            <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ \App\Models\DaftarPoli::count() }}</p>
                            <p class="mt-2 text-xs text-slate-500">Total pendaftaran pasien</p>
                        </div>
                    </section>

                    <section class="mt-8 grid gap-6 xl:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-900">Akses Cepat</h3>
                                    <p class="mt-1 text-sm text-slate-500">Kelola aktivitas utama klinik</p>
                                </div>
                            </div>
                            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                <a href="#" class="rounded-xl bg-teal-50 p-4 transition hover:bg-teal-100"><span class="text-sm font-bold text-teal-800">Tambah Pasien</span><span class="mt-1 block text-xs text-teal-600">Daftarkan pengguna baru</span></a>
                                <a href="#" class="rounded-xl bg-cyan-50 p-4 transition hover:bg-cyan-100"><span class="text-sm font-bold text-cyan-800">Atur Jadwal</span><span class="mt-1 block text-xs text-cyan-600">Kelola jadwal dokter</span></a>
                                <a href="#" class="rounded-xl bg-amber-50 p-4 transition hover:bg-amber-100"><span class="text-sm font-bold text-amber-800">Kelola Obat</span><span class="mt-1 block text-xs text-amber-600">Perbarui data obat</span></a>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h3 class="font-bold text-slate-900">Status Sistem</h3>
                            <div class="mt-5 flex items-center gap-3 rounded-xl bg-emerald-50 p-4">
                                <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                                <div><p class="text-sm font-semibold text-emerald-800">Sistem aktif</p><p class="text-xs text-emerald-600">Semua layanan berjalan normal</p></div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
