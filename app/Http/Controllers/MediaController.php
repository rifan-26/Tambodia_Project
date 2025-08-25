<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Log;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Auth::user()->isSuperAdmin() 
            ? Media::with('user') 
            : Media::where('user_id', Auth::id());
        
        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Date filter
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $media = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenisMedia' => 'required|in:audio,image,video',
            'namaFile' => 'required|string|max:255',
            'file' => 'required|file|max:50000' // 50MB max
        ]);

        // Handle file upload
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        
        // Generate unique filename
        $fileName = time() . '_' . $originalName;
        
        // Store file
        $filePath = $file->storeAs('media', $fileName, 'public');
        
        // Map frontend types to database types
        $typeMap = [
            'audio' => 'Audio',
            'image' => 'Gambar', 
            'video' => 'Video'
        ];

        // Create media record
        $media = Media::create([
            'user_id' => Auth::id(),
            'name' => $request->namaFile,
            'type' => $typeMap[$request->jenisMedia],
            'file_path' => $filePath,
            'original_filename' => $originalName,
            'date' => now()->toDateString(),
        ]);

        // Log activity
        Log::createLog(Auth::id(), 'Upload Media', "Uploaded {$media->type}: {$media->name}");

        return response()->json([
            'success' => true,
            'message' => 'Media berhasil diupload!',
            'media' => $media
        ]);
    }

    public function toggleLanding(Request $request)
    {
        $mediaIds = $request->input('media_ids', []);
        
        if (empty($mediaIds)) {
            return response()->json(['success' => false, 'message' => 'Pilih media terlebih dahulu']);
        }

        $count = Media::whereIn('id', $mediaIds)
                     ->where('user_id', Auth::id())
                     ->update(['show_on_landing' => true]);

        // Log activity
        Log::createLog(Auth::id(), 'Set Landing Media', "Set {$count} media to show on landing page");

        return response()->json([
            'success' => true,
            'message' => "{$count} media berhasil diatur untuk tampil di landing page"
        ]);
    }

    public function destroy($id)
    {
        $media = Media::where('id', $id)->where('user_id', Auth::id())->first();
        
        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Media tidak ditemukan']);
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        // Log before delete
        Log::createLog(Auth::id(), 'Delete Media', "Deleted {$media->type}: {$media->name}");

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media berhasil dihapus'
        ]);
    }
}