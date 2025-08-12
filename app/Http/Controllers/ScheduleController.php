<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Schedule;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as RoutingController;

class ScheduleController extends RoutingController
{
    public function __construct()
    {
        $this->middleware('auth');
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
            'time' => 'nullable|date_format:H:i'
        ]);

        // Verify media belongs to user
        $media = Media::where('id', $request->media_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $schedule = Schedule::create($request->all());

        // Log activity
        Log::createLog(Auth::id(), 'Create Schedule', "Created schedule for media: {$media->name}");

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dibuat!',
            'schedule' => $schedule
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
            'time' => 'nullable|date_format:H:i'
        ]);

        $schedule->update($request->all());

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
}
