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
        $request->validate([
            'media_id' => 'required|exists:media,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time' => 'nullable|date_format:H:i',
            'layout_position' => 'required|integer|min:1|max:6',
            'display_duration' => 'nullable|integer|min:1|max:300',
            'auto_rotate' => 'nullable|boolean'
        ]);

        // Verify media belongs to user
        $media = Media::where('id', $request->media_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // Check if position is already scheduled for the same time period
        $existingSchedule = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->where('layout_positions', 'like', '%"' . $request->layout_position . '"%')
        ->where('is_active', true)
        ->where(function($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function($q) use ($request) {
                      $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                  });
        })
        ->first();

        if ($existingSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'Posisi ' . $request->layout_position . ' sudah dijadwalkan untuk periode tersebut!'
            ]);
        }

        // Prepare data for creation
        $scheduleData = $request->all();
        $scheduleData['display_duration'] = $request->display_duration ?? 10;
        $scheduleData['auto_rotate'] = $request->auto_rotate ?? true;
        $scheduleData['is_active'] = true;
        $scheduleData['layout_type'] = 'position'; // Set layout type as position-based
        $scheduleData['layout_positions'] = [$request->layout_position]; // Store position as array

        $schedule = Schedule::create($scheduleData);

        // Log activity
        Log::createLog(Auth::id(), 'Create Schedule', "Created schedule for media: {$media->name} at position: {$request->layout_position}");

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dibuat!',
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
            'end_date' => 'required|date|after_or_equal:start_date',
            'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time' => 'nullable|date_format:H:i',
            'layout_position' => 'required|integer|min:1|max:6',
            'display_duration' => 'nullable|integer|min:1|max:300',
            'auto_rotate' => 'nullable|boolean'
        ]);

        $updateData = $request->all();
        $updateData['layout_positions'] = [$request->layout_position];
        
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
        $schedule = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        // Log before delete
        Log::createLog(Auth::id(), 'Delete Schedule', "Deleted schedule for media: {$schedule->media->name}");

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus!'
        ]);
    }

    // Get all active schedules for current user
    public function getActiveSchedules()
    {
        $activeSchedules = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->currentlyActive()
        ->with(['media'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'schedules' => $activeSchedules
        ]);
    }

    // Toggle schedule active status
    public function toggleStatus($id)
    {
        $schedule = Schedule::whereHas('media', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $schedule->is_active = !$schedule->is_active;
        $schedule->save();

        $status = $schedule->is_active ? 'activated' : 'deactivated';
        Log::createLog(Auth::id(), 'Toggle Schedule', "Schedule {$status} for media: {$schedule->media->name}");

        return response()->json([
            'success' => true,
            'message' => 'Status jadwal berhasil diubah!',
            'is_active' => $schedule->is_active
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
}