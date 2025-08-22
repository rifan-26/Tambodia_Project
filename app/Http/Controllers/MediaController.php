<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected $middleware = ['auth'];
    /** 
     * List media milik user login 
     */
    public function index(Request $request)
    {
        $query = Media::where('user_id', Auth::id());

        if ($request->filled('type')) {
            $query->where('type', ucfirst(strtolower($request->type)));
        }

        $media = $query->latest()->get();

        return view('input', compact('media'));
    }

    /**
     * Upload media baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenisMedia' => 'required|in:audio,image,video',
            'namaFile'   => 'required|string|max:255',
            'file'       => 'required|file|max:51200' // 50MB
        ]);

        $file        = $request->file('file');
        $original    = $file->getClientOriginalName();
        $fileName    = time() . '_' . $original;
        $filePath    = $file->storeAs('media', $fileName, 'public');

        $typeMap = [
            'audio' => 'Audio',
            'image' => 'Gambar',
            'video' => 'Video'
        ];

        $media = Media::create([
            'user_id'          => Auth::id(),
            'name'             => $request->namaFile,
            'type'             => $typeMap[$request->jenisMedia],
            'file_path'        => $filePath,
            'original_filename'=> $original,
            'date'             => now()->toDateString(),
        ]);

        Log::createLog(Auth::id(), 'Upload Media', "Uploaded {$media->type}: {$media->name}");

        return redirect()
        ->route('dashboard.pegawai')
        ->with('success', 'Media berhasil diupload!');
    }

    /**
     * Tandai media untuk tampil di landing page
     */
    public function toggleLanding(Request $request)
    {
        $mediaIds = $request->input('media_ids', []);

        if (empty($mediaIds)) {
            return response()->json(['success' => false, 'message' => 'Pilih media terlebih dahulu']);
        }

        $count = Media::whereIn('id', $mediaIds)
                    ->where('user_id', Auth::id())
                    ->update(['show_on_landing' => true]);

        Log::createLog(Auth::id(), 'Set Landing Media', "Set {$count} media to show on landing page");

        return response()->json([
            'success' => true,
            'message' => "{$count} media berhasil diatur untuk tampil di landing page"
        ]);
    }

    /**
     * Hapus media
     */
    public function destroy($id)
    {
        $media = Media::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Media tidak ditemukan']);
        }

        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        Log::createLog(Auth::id(), 'Delete Media', "Deleted {$media->type}: {$media->name}");

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media berhasil dihapus'
        ]);
    }
}
