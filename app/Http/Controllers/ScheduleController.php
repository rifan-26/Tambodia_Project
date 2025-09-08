<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Schedule;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        // Middleware auth sudah diterapkan di routes/web.php
    }

    public function index(Request $request)
    {
        $query = Media::where('user_id', Auth::id());
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $media = $query->with('schedules')->orderBy('created_at', 'desc')->get();
        
        return view('jadwal', compact('media'));
    }

    public function store(Request $request)
    {
        // Verify media belongs to user first
        $media = Media::where('id', $request->media_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // Different validation based on media type
        if ($media->type === 'Audio') {
            // Audio: Requires duration, no layout position
            $request->validate([
                'media_id' => 'required|exists:media,id',
                'start_date' => 'required|date',
                'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
                'time' => 'nullable|date_format:H:i',
                'display_duration' => 'required|integer|min:1|max:300', // Required for audio
                'auto_rotate' => 'nullable|boolean'
            ]);
        } else {
            // Gambar & Video: Requires layout position, no duration
            $request->validate([
                'media_id' => 'required|exists:media,id',
                'start_date' => 'required|date',
                'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
                'time' => 'nullable|date_format:H:i',
                'layout_position' => 'required|integer|min:1|max:6', // Required for visual media
                'auto_rotate' => 'nullable|boolean'
            ]);
        }

        // Create basic schedule with existing columns only
        $scheduleData = [
            'media_id' => $request->media_id,
            'start_date' => $request->start_date,
            'day_of_week' => $request->day_of_week,
            'time' => $request->time
        ];

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
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $request->validate([
            'start_date' => 'required|date',
            'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time' => 'nullable|date_format:H:i'
        ]);

        $updateData = [
            'start_date' => $request->start_date,
            'day_of_week' => $request->day_of_week,
            'time' => $request->time
        ];
        
        $schedule->update($updateData);

        // Log activity
        Log::createLog(Auth::id(), 'Update Schedule', "Updated schedule for media: {$schedule->media->name}");

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diupdate!'
        ]);
    }

    public function destroy($id)
    {
        try {
            $schedule = Schedule::whereHas('media', function($query) {
                $query->where('user_id', Auth::id());
            })->with('media')->findOrFail($id);

            $mediaName = $schedule->media->name;
            $schedule->delete();

            // Log the deletion
            Log::createLog(Auth::id(), 'Delete Schedule', "Deleted schedule for media: {$mediaName}");

            return response()->json([
                'success' => true,
                'message' => "Jadwal untuk media '{$mediaName}' berhasil dihapus"
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
        $activeSchedules = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->with(['media'])
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

        $activeAudioSchedules = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id())
                  ->where('type', 'Audio');
        })
        ->where('start_date', '<=', $currentDate)
        ->where(function($query) use ($currentDay) {
            $query->whereNull('day_of_week')
                  ->orWhere('day_of_week', $currentDay);
        })
        ->with(['media'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'audio_schedules' => $activeAudioSchedules
        ]);
    }

    // Get schedule details
    public function show($id)
    {
        $schedule = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })->with('media')->findOrFail($id);

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