<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware auth sudah diterapkan di routes/web.php
    }

    public function index(Request $request)
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
        
        // Get active audio schedules for dashboard
        $activeAudioSchedules = $this->getActiveAudioSchedules();
        
        return view('Dashboard', compact('media', 'activeAudioSchedules'));
    }
    
    /**
     * Get currently active audio schedules
     */
    private function getActiveAudioSchedules()
    {
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');
        $indonesianDay = $this->getIndonesianDay();

        return \App\Models\Schedule::join('media', 'schedules.media_id', '=', 'media.id')
            ->where('media.type', 'Audio')
            ->where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $currentDate);
            })
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '=', $currentTime)
                      ->orWhere('time', '<=', $currentTime);
            })
            ->select('schedules.*')
            ->with('media')
            ->orderBy('schedules.start_date', 'desc')
            ->orderBy('schedules.time', 'desc')
            ->get();
    }

    public function pegawai(Request $request)
    {
        return $this->index($request);
    }

    public function superadmin()
    {
        $totalMedia = Media::count();
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalSuperadmin = User::where('role', 'superadmin')->count();
        $recentLogs = Log::with('user')->latest()->take(10)->get();
        
        $mediaByType = [
            'Gambar' => Media::where('type', 'Gambar')->count(),
            'Video' => Media::where('type', 'Video')->count(),
            'Audio' => Media::where('type', 'Audio')->count(),
        ];
        
        // Get all users for the admin table (both superadmin and pegawai) - oldest first
        $admins = User::orderBy('created_at', 'asc')->get();
        
        return view('superadmin', compact('totalMedia', 'totalPegawai', 'totalSuperadmin', 'recentLogs', 'mediaByType', 'admins'));
    }

    public function destroy($id)
    {
        try {
            $media = Media::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

            // Delete the file from storage
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }

            // Log the deletion
            Log::createLog(Auth::id(), 'Delete Media', "Deleted {$media->type}: {$media->name}");

            // Delete the database record
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Media berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Media tidak ditemukan atau tidak memiliki akses'
            ], 404);
        }
    }

    /**
     * Get active audio schedules for dashboard
     */
    public function getActiveAudioSchedulesApi()
    {
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');
        $indonesianDay = $this->getIndonesianDay();

        $audioSchedules = \App\Models\Schedule::join('media', 'schedules.media_id', '=', 'media.id')
            ->where('media.type', 'Audio')
            ->where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $currentDate);
            })
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '=', $currentTime)
                      ->orWhere('time', '<=', $currentTime);
            })
            ->select('schedules.*', 'media.name as media_name', 'media.file_path', 'media.type')
            ->orderBy('schedules.start_date', 'desc')
            ->orderBy('schedules.time', 'desc')
            ->get();

        // Load media relationships
        $audioSchedules->load('media');

        $scheduleData = [];
        foreach ($audioSchedules as $schedule) {
            $scheduleData[] = [
                'id' => $schedule->id,
                'media' => [
                    'id' => $schedule->media_id,
                    'name' => $schedule->media_name,
                    'file_path' => $schedule->file_path,
                    'type' => $schedule->type
                ],
                'display_duration' => $schedule->display_duration ?? 10,
                'time' => $schedule->time,
                'start_date' => $schedule->start_date,
                'end_date' => $schedule->end_date,
                'is_currently_active' => true
            ];
        }

        return response()->json([
            'success' => true,
            'schedules' => $scheduleData
        ]);
    }

    /**
     * Get Indonesian day name
     */
    private function getIndonesianDay()
    {
        $dayMap = [
            'monday' => 'senin',
            'tuesday' => 'selasa', 
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu'
        ];

        $englishDay = strtolower(now()->format('l'));
        return $dayMap[$englishDay] ?? null;
    }
}
