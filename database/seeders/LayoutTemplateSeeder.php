<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayoutTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 sample templates
        \App\Models\LayoutTemplate::factory()->create([
            'name' => 'Template Default BPS',
            'description' => 'Template default untuk halaman landing BPS dengan grid 2x2',
            'grid_type' => '2x2',
            'is_active' => true, // Set as active template
        ]);

        \App\Models\LayoutTemplate::factory()->create([
            'name' => 'Template 3 Kolom',
            'description' => 'Template dengan 3 kolom untuk menampilkan informasi side by side',
            'grid_type' => '3-col',
        ]);

        \App\Models\LayoutTemplate::factory()->create([
            'name' => 'Template Grid Besar',
            'description' => 'Template dengan grid 3x3 untuk banyak konten',
            'grid_type' => '3x3',
        ]);
    }
}
