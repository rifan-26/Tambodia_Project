<?php
namespace App\Http\Controllers;
use App\Models\Media;
use App\Models\Schedule;
use App\Models\LayoutSetting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        try {
            // Increase execution time limit for this specific request
            set_time_limit(60);
            
            // Optimize query by selecting only necessary columns and limiting results
            $layoutImages = Media::select('id', 'name', 'file_path', 'type', 'layout_order')
                ->where('show_on_landing', true)
                ->whereIn('type', ['Gambar', 'Video'])
                ->whereNotNull('layout_order')
                ->orderBy('layout_order', 'asc')
                ->limit(6) // Only get first 6 items for the grid
                ->get();

            // Get layout settings with caching
            $layoutSetting = cache()->remember('layout_setting', 300, function () {
                return LayoutSetting::first();
            });
            
            $description = $layoutSetting && $layoutSetting->description 
                ? $layoutSetting->description 
                : 'Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.';
            
            // Get background image efficiently
            $backgroundImage = null;
            if ($layoutSetting && $layoutSetting->background_image_id) {
                $backgroundImage = cache()->remember("background_image_{$layoutSetting->background_image_id}", 300, function () use ($layoutSetting) {
                    return Media::select('id', 'file_path')->find($layoutSetting->background_image_id);
                });
            }

            // For backward compatibility, set media to layoutImages
            $media = $layoutImages;

            return view('landingpage', compact('media', 'layoutImages', 'description', 'backgroundImage'));
            
        } catch (\Exception $e) {
            // Log the error and return a fallback view
            \Log::error('Landing page error: ' . $e->getMessage());
            
            return view('landingpage', [
                'media' => collect([]),
                'layoutImages' => collect([]),
                'description' => 'Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.',
                'backgroundImage' => null
            ]);
        }
    }
}