<?php

namespace Database\Seeders;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $poliUmum = Poli::firstOrCreate(
            ['nama_poli' => 'Poli Umum'],
            ['keterangan' => 'Pemeriksaan umum']
        );

        $poliGigi = Poli::firstOrCreate(
            ['nama_poli' => 'Poli Gigi'],
            ['keterangan' => 'Pemeriksaan gigi']
        );

        $poliAnak = Poli::firstOrCreate(
            ['nama_poli' => 'Poli Anak'],
            ['keterangan' => 'Pemeriksaan kesehatan anak']
        );

        $users = [
            [
                'nama' => 'Administrator Klinik',
                'alamat' => 'Jl. Utama No. 1',
                'no_ktp' => '3273010001800000',
                'no_hp' => '081234567800',
                'no_rm' => 'ADM-0001',
                'role' => 'admin',
                'id_poli' => $poliUmum->id,
                'email' => 'admin@poliklinik.test',
            ],
            [
                'nama' => 'Dr. Budi Santoso',
                'alamat' => 'Jl. Melati No. 10',
                'no_ktp' => '3273010101800001',
                'no_hp' => '081234567801',
                'no_rm' => 'DOK-0001',
                'role' => 'dokter',
                'id_poli' => $poliUmum->id,
                'email' => 'dokter.umum@poliklinik.test',
            ],
            [
                'nama' => 'Dr. Siti Rahma',
                'alamat' => 'Jl. Kenanga No. 22',
                'no_ktp' => '3273010202800002',
                'no_hp' => '081234567802',
                'no_rm' => 'DOK-0002',
                'role' => 'dokter',
                'id_poli' => $poliGigi->id,
                'email' => 'dokter.gigi@poliklinik.test',
            ],
            [
                'nama' => 'Andi Pratama',
                'alamat' => 'Jl. Mawar No. 5',
                'no_ktp' => '3273010303900003',
                'no_hp' => '081234567803',
                'no_rm' => 'RM-0001',
                'role' => 'pasien',
                'id_poli' => $poliUmum->id,
                'email' => 'andi@poliklinik.test',
            ],
            [
                'nama' => 'Dewi Lestari',
                'alamat' => 'Jl. Anggrek No. 8',
                'no_ktp' => '3273010404900004',
                'no_hp' => '081234567804',
                'no_rm' => 'RM-0002',
                'role' => 'pasien',
                'id_poli' => $poliGigi->id,
                'email' => 'dewi@poliklinik.test',
            ],
            [
                'nama' => 'Raka Wijaya',
                'alamat' => 'Jl. Dahlia No. 14',
                'no_ktp' => '3273010505900005',
                'no_hp' => '081234567805',
                'no_rm' => 'RM-0003',
                'role' => 'pasien',
                'id_poli' => $poliAnak->id,
                'email' => 'raka@poliklinik.test',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [...$user, 'password' => Hash::make('password')]
            );
        }
    }
}
