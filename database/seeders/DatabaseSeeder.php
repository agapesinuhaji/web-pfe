<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

         // buat admin
        // $admin = User::create([
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('12345678'), 
        //     'role' => 'administrator',
        // ]);

        // Profile::create([
        //     'user_id' => $admin->id,
        //     'name' => 'Administrator',
        //     'image' => 'profile/noimage.png',
        // ]);

        // // buat psikolog
        // $psychologist = User::create([
        //     'email' => 'psikolog@example.com',
        //     'password' => Hash::make('12345678'),
        //     'role' => 'psikolog',
        // ]);

        // Profile::create([
        //     'user_id' => $psychologist->id,
        //     'name' => 'Psikolog',
        //     'image' => 'profile/noimage.png',
        // ]);

        // $psychologist = User::create([
        //     'email' => 'psikolog2@example.com',
        //     'password' => Hash::make('12345678'),
        //     'role' => 'psikolog',
        // ]);

        // Profile::create([
        //     'user_id' => $psychologist->id,
        //     'name' => 'Psikolog Dua',
        //     'image' => 'profile/noimage.png',
        // ]);


        //  Order::create([
        //     'order_uuid' => (string) Str::uuid(),
        //     'user_id'        => 5,
        //     'product_id'     => 1,
        //     'schedule_id'    => 2,
        //     'method_id' => 2,
        //     'conselor_id'   => 2,
        //     'price'          => 45000,
        //     'unique_kode'    => 123,
        //     'total'          => 45523,
        //     'payment_method_id'  => null,
        //     'status'         => 'approved',
        //     'created_at'     => '2025-09-04 16:22:17',
        //     'updated_at'     => '2025-09-04 16:22:17',
        //     'link'   => 'https://meet.google.com/landing',
        // ]);
    }
}
