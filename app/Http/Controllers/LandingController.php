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
        // Get media that should be displayed on landing page (images and videos), ordered by layout_order
        $media = Media::where('show_on_landing', true)
            ->whereIn('type', ['Gambar', 'Video'])
            ->orderBy('layout_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get layout media (images and videos) specifically for the grid display
        $layoutImages = Media::where('show_on_landing', true)
            ->whereIn('type', ['Gambar', 'Video'])
            ->whereNotNull('layout_order')
            ->orderBy('layout_order', 'asc')
            ->get();

        // Get layout description and background from settings
        $layoutSetting = LayoutSetting::first(); // Get any layout setting
        $description = $layoutSetting && $layoutSetting->description ? $layoutSetting->description : 'Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.';
        
        // Get background image
        $backgroundImage = null;
        if ($layoutSetting && $layoutSetting->background_image_id) {
            $backgroundImage = Media::find($layoutSetting->background_image_id);
        }

        return view('landingpage', compact('media', 'layoutImages', 'description', 'backgroundImage'));
    }
}