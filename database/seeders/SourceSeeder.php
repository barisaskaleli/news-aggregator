<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sources')->insert([
            [
                'name' => 'News API',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'The Guardian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'The New York Times',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
