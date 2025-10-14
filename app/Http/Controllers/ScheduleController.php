<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Schedule;
use App\Models\LayoutSetting;
use App\Models\ScheduledBackground;
use App\Models\ScheduleDescription;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function __construct()
    {
        // Middleware auth sudah diterapkan di routes/web.php
    }

    public function index(Request $request)
    {
        // Remove user_id filtering to show all media to all admins
        $query = Media::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $media = $query->with('schedules')->orderBy('created_at', 'desc')->get();
        
        // Get layout settings for the current user
        $layoutSettings = LayoutSetting::firstOrCreate(
            ['user_id' => Auth::id()],
            ['description' => '']
        );
        
        // Load the background media relationship
        $layoutSettings->load('backgroundMedia');
        
        // Get all media that can be used as background (remove user_id filter for cross-admin access)
        $backgroundMedia = Media::whereIn('type', ['Gambar', 'Video'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get scheduled backgrounds and descriptions
        $scheduledBackgrounds = ScheduledBackground::with('media')
            ->where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->get();

        $scheduledDescriptions = ScheduleDescription::where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->get();

        return view('jadwal', compact('media', 'layoutSettings', 'backgroundMedia', 'scheduledBackgrounds', 'scheduledDescriptions'));
    }

    public function store(Request $request)
    {
        try {
            // Debug incoming request
            \Log::info('Schedule Store Request', [
                'all_data' => $request->all(),
                'start_date' => $request->start_date,
                'media_id' => $request->media_id
            ]);

        // Get media (remove user_id filter for cross-admin access)
        $media = Media::where('id', $request->media_id)
                    ->firstOrFail();

        // Different validation based on media type
        if ($media->type === 'Audio') {
            // Audio: Requires duration, no layout position
            $request->validate([
                'media_id' => 'required|exists:media,id',
                'start_date' => 'required|date',
                'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
                'time' => 'nullable|date_format:H:i',
                'layout_position' => 'nullable|integer|min:1|max:6',
            ]);
        } else {
            // Gambar & Video: Requires layout position, no duration
            $request->validate([
                'media_id' => 'required|exists:media,id',
                'start_date' => 'required|date',
                'day_of_week' => 'nullable|string',
                'time' => 'nullable|date_format:H:i',
                'layout_position' => 'required|integer|between:1,6',
            ]);
        }

        // Prepare data for creation
        $scheduleData = $request->all();
        $scheduleData['display_duration'] = $request->display_duration ?? 10;

        $schedule = Schedule::create($scheduleData);

        // Different log message and response based on media type
        if ($media->type === 'Audio') {
            Log::createLog(Auth::id(), 'Create Audio Schedule', "Created audio schedule for: {$media->name} (duration: {$request->display_duration}s)");
            $message = 'Jadwal audio berhasil dibuat! Audio akan diputar di dashboard sesuai jadwal.';
        } else {
            Log::createLog(Auth::id(), 'Create Visual Schedule', "Created visual schedule for: {$media->name} at position: {$request->layout_position}");
            $message = 'Jadwal media berhasil dibuat! Media akan tampil di landing page sesuai jadwal.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'media_type' => $media->type,
            'schedule' => $schedule->load('media')
        ]);
        
        } catch (\Exception $e) {
            \Log::error('Schedule creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Remove user_id filter for cross-admin access
            $schedule = Schedule::with('media')->findOrFail($id);
            $media = $schedule->media;

            // Flexible validation - only validate fields that are present
            $rules = [];
            
            if ($request->has('start_date')) {
                $rules['start_date'] = 'date';
            }
            if ($request->has('end_date')) {
                $rules['end_date'] = 'nullable|date';
            }
            if ($request->has('day_of_week')) {
                $rules['day_of_week'] = 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu';
            }
            if ($request->has('time')) {
                $rules['time'] = 'nullable|date_format:H:i';
            }
            if ($request->has('layout_position') && $media->type !== 'Audio') {
                $rules['layout_position'] = 'nullable|integer|between:1,6';
            }

            $request->validate($rules);

            // Build update data only with provided fields
            $updateData = [];
            
            if ($request->has('start_date')) {
                $updateData['start_date'] = $request->start_date;
            }
            if ($request->has('end_date')) {
                $updateData['end_date'] = $request->end_date;
            }
            if ($request->has('day_of_week')) {
                $updateData['day_of_week'] = $request->day_of_week;
            }
            if ($request->has('time')) {
                $updateData['time'] = $request->time;
            }
            if ($request->has('layout_position')) {
                $updateData['layout_position'] = $request->layout_position;
            }
            
            $schedule->update($updateData);

            // Log activity
            Log::createLog(Auth::id(), 'Update Schedule', "Updated schedule for media: {$schedule->media->name}");

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil diupdate!',
                'schedule' => $schedule->load('media')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Schedule update failed', [
                'error' => $e->getMessage(),
                'schedule_id' => $id,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $schedule = Schedule::with('media')->findOrFail($id);

            $mediaName = $schedule->media->name;
            $media = $schedule->media;
            
            // Remove media from landing page if it's visual media
            if (in_array($media->type, ['Gambar', 'Video'])) {
                $media->update([
                    'show_on_landing' => false,
                    'layout_order' => null
                ]);
            }
            
            $schedule->delete();

            // Log the deletion
            Log::createLog(Auth::id(), 'Delete Schedule', "Deleted schedule for media: {$mediaName} and removed from landing page");

            return response()->json([
                'success' => true,
                'message' => "Jadwal untuk media '{$mediaName}' berhasil dihapus dan media dihilangkan dari landing page"
            ]);

        } catch (\Exception $e) {
            Log::createLog(Auth::id(), 'Delete Schedule Failed', "Failed to delete schedule ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jadwal. Silakan coba lagi.'
            ], 500);
        }
    }

    // Get all active schedules for current user
    public function getActiveSchedules()
    {
        $activeSchedules = Schedule::with(['media'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'schedules' => $activeSchedules
        ]);
    }

    // Get active audio schedules for dashboard
    public function getActiveAudioSchedules()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentDay = $this->getDayOfWeekInIndonesian($now->dayOfWeek);

        $activeAudioSchedules = Schedule::join('media', 'schedules.media_id', '=', 'media.id')
            ->where('media.type', 'Audio')
        ->where('start_date', '<=', $currentDate)
        ->where(function($query) use ($currentDay) {
            $query->whereNull('day_of_week')
                  ->orWhere('day_of_week', $currentDay);
        })
        ->select('schedules.*', 'media.name as media_name', 'media.file_path', 'media.type')
        ->orderBy('schedules.created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'audio_schedules' => $activeAudioSchedules
        ]);
    }

    // Get schedule details
    public function show($id)
    {
        $schedule = Schedule::with('media')->findOrFail($id);

        return response()->json([
            'success' => true,
            'schedule' => $schedule
        ]);
    }


    /**
     * Convert day number to Indonesian day name
     */
    private function getDayOfWeekInIndonesian($dayNumber)
    {
        $days = [
            0 => 'minggu',
            1 => 'senin', 
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu'
        ];

        return $days[$dayNumber] ?? null;
    }
}