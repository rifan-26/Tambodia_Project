<?php
namespace App\Http\Controllers;
use App\Models\Media;
use App\Models\Schedule;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get all media that should be displayed on landing page
        $allMedia = Media::where('show_on_landing', true)
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        // Separate by type
        $images = $allMedia->where('type', 'Gambar');
        $videos = $allMedia->where('type', 'Video');
        $audioFiles = $allMedia->where('type', 'Audio');
        
        // Get featured items (latest 5)
        $featured = $allMedia->take(5);
        
        // Statistics
        $stats = [
            'images' => $images->count(),
            'videos' => $videos->count(),
            'audio' => $audioFiles->count(),
        ];
        
        return view('landing', compact('images', 'videos', 'audioFiles', 'featured', 'stats'));
    }
}
