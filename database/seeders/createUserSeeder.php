<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class createUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'superadmin',
            'name' => 'superadmin',
            'email' =>  'superadmin@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'superadmin',
        ]);

        User::create([
            'username' => 'regis_klaim',
            'name' => 'admin regis klaim',
            'email' =>  'klaim@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'registrasi-klaim',
        ]);

        User::create([
            'username' => 'mobile_service',
            'name' => 'admin mobile service',
            'email' =>  'mobileservice@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'mobile-service',
        ]);

        User::create([
            'username' => 'pj_pelayanan',
            'name' => 'admin pj pelayanan',
            'email' =>  'pjpelayanan@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'pj-pelayanan',
        ]);
        User::create([
            'username' => 'keuangan_umum',
            'name' => 'admin keuangan umum',
            'email' =>  'keuanganumum@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'keuangan-umum',
        ]);
        User::create([
            'username' => 'pembayaran_klaim',
            'name' => 'admin pembayaran klaim',
            'email' =>  'pembayaranklaim@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'pembayaran-klaim',
        ]);
    }
}
