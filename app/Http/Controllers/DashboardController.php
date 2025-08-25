<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware auth sudah diterapkan di routes/web.php
    }

    public function pegawai(Request $request)
    {
        $query = Media::where('user_id', Auth::id());
        
        // Filter berdasarkan jenis media jika ada
        if ($request->has('type') && $request->type != '') {
            $typeMap = [
                'image' => 'Gambar',
                'video' => 'Video', 
                'audio' => 'Audio'
            ];
            
            if (isset($typeMap[strtolower($request->type)])) {
                $query->where('type', $typeMap[strtolower($request->type)]);
            }
        }
        
        $media = $query->orderBy('created_at', 'desc')->get();
        
        return view('dashboard', compact('media'));
    }

    public function superadmin()
    {
        $totalMedia = Media::count();
        $totalPegawai = User::where('role', 'pegawai')->count();
        $recentLogs = Log::with('user')->latest()->take(10)->get();
        $mediaByType = [
            'Gambar' => Media::where('type', 'Gambar')->count(),
            'Video' => Media::where('type', 'Video')->count(),
            'Audio' => Media::where('type', 'Audio')->count(),
        ];
        
        // Get admin users for the management table
        $admins = User::where('role', 'pegawai')->orderBy('created_at', 'desc')->get();
        
        return view('superadmin', compact('totalMedia', 'totalPegawai', 'recentLogs', 'mediaByType', 'admins'));
    }
}
