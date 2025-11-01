<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'room_number' => '101',
                'name' => 'Single Room',
                'capacity' => 15,
                'price_per_night' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '102',
                'name' => 'Double Room',
                'capacity' => 10,
                'price_per_night' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '201',
                'name' => 'Deluxe Suite',
                'capacity' => 2,
                'price_per_night' => 800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '202',
                'name' => 'Suite',
                'capacity' => 4,
                'price_per_night' => 600,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '301',
                'name' => 'Twin Room',
                'capacity' => 8,
                'price_per_night' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => '302',
                'name' => 'Triple Room',
                'capacity' => 5,
                'price_per_night' => 400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
