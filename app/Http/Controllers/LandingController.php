<?php
namespace App\Http\Controllers;
use App\Models\Media;
use App\Models\Schedule;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get media that should be displayed on landing page
        $media = Media::where('show_on_landing', true)
                     ->whereHas('schedules', function($query) {
                         $query->active();
                     })
                     ->with(['schedules' => function($query) {
                         $query->active();
                     }])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('landingpage', compact('media'));
    }
}