<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingPageMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset all media first
        DB::table('media')->update([
            'show_on_landing' => false,
            'layout_order' => null
        ]);

        // Get first 4 media items (Gambar or Video only, for portrait layout)
        $mediaItems = DB::table('media')
            ->whereIn('type', ['Gambar', 'Video'])
            ->orderBy('id')
            ->limit(4)
            ->get();

        if ($mediaItems->count() > 0) {
            foreach ($mediaItems as $index => $media) {
                DB::table('media')
                    ->where('id', $media->id)
                    ->update([
                        'show_on_landing' => true,
                        'layout_order' => $index + 1
                    ]);
                
                $this->command->info("Set media ID {$media->id} ({$media->name}) to position " . ($index + 1));
            }
            
            $this->command->info("Successfully set {$mediaItems->count()} media items for landing page!");
        } else {
            $this->command->warn("No media found in database!");
        }
    }
}
