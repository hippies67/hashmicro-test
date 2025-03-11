<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('pegawai')->insert([
            [
                'nama_pegawai' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'gajih' => 5000000,
                'departemen_id' => 1,
                'bonus_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_pegawai' => 'Bob Smith',
                'email' => 'bob.smith@example.com',
                'gajih' => 6000000,
                'departemen_id' => 2,
                'bonus_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_pegawai' => 'Carol Diaz',
                'email' => 'carol.diaz@example.com',
                'gajih' => 7000000,
                'departemen_id' => 3,
                'bonus_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_pegawai' => 'David Lee',
                'email' => 'david.lee@example.com',
                'gajih' => 5500000,
                'departemen_id' => 4,
                'bonus_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_pegawai' => 'Emma Brown',
                'email' => 'emma.brown@example.com',
                'gajih' => 5800000,
                'departemen_id' => 5,
                'bonus_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
