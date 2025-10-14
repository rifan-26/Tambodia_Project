<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class ScheduleDescriptionController extends Controller
{
    public function index()
    {
        $descriptions = ScheduleDescription::where('user_id', Auth::id())
                                         ->orderBy('start_date', 'desc')
                                         ->get();
        
        return response()->json([
            'success' => true,
            'data' => $descriptions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:2000',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time' => 'nullable|date_format:H:i',
        ]);

        $description = ScheduleDescription::create([
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'day_of_week' => $request->day_of_week,
            'time' => $request->time,
            'user_id' => Auth::id(),
            'is_active' => true
        ]);

        Log::createLog(Auth::id(), 'Create Description Schedule', "Created description schedule: {$description->description}");

        return response()->json([
            'success' => true,
            'message' => 'Jadwal deskripsi berhasil dibuat',
            'data' => $description
        ]);
    }

    public function update(Request $request, $id)
    {
        $description = ScheduleDescription::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'description' => 'required|string|max:2000',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time' => 'nullable|date_format:H:i',
            'is_active' => 'boolean'
        ]);

        $description->update($request->all());

        Log::createLog(Auth::id(), 'Update Description Schedule', "Updated description schedule ID: {$id}");

        return response()->json([
            'success' => true,
            'message' => 'Jadwal deskripsi berhasil diperbarui',
            'data' => $description
        ]);
    }

    public function destroy($id)
    {
        $description = ScheduleDescription::where('user_id', Auth::id())->findOrFail($id);
        
        $descriptionText = $description->description;
        $description->delete();

        Log::createLog(Auth::id(), 'Delete Description Schedule', "Deleted description schedule: {$descriptionText}");

        return response()->json([
            'success' => true,
            'message' => 'Jadwal deskripsi berhasil dihapus'
        ]);
    }

    public function getActiveDescription()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->translatedFormat('l')); // Get day name in Indonesian

        // Map English day names to Indonesian
        $dayMap = [
            'monday' => 'senin',
            'tuesday' => 'selasa', 
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu'
        ];

        $indonesianDay = $dayMap[$currentDay] ?? null;

        $activeDescription = ScheduleDescription::active($currentDate)
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '<=', $currentTime);
            })
            ->orderBy('start_date', 'desc')
            ->orderBy('time', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $activeDescription
        ]);
    }
}
