<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function __construct()
    {
        // Middleware auth sudah diterapkan di routes/web.php
    }

    /** 
     * List media milik user login 
     */
    public function index(Request $request)
    {
        try {
            // Start with a base query and eager load any relationships if needed
            $query = Media::where('user_id', Auth::id());
            
            // Apply filters
            // Filter by type if provided
            if ($request->filled('type')) {
                $query->where('type', ucfirst(strtolower($request->type)));
            }
            
            // Search by name if provided
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            
            // Optimize query with pagination
            $perPage = $request->filled('per_page') ? (int)$request->per_page : 12;
            
            // Handle AJAX requests for filtering/searching
            if ($request->ajax()) {
                $media = $query->latest()->paginate($perPage);
                return response()->json([
                    'success' => true,
                    'data' => $media->items(),
                    'pagination' => [
                        'total' => $media->total(),
                        'per_page' => $media->perPage(),
                        'current_page' => $media->currentPage(),
                        'last_page' => $media->lastPage()
                    ]
                ]);
            }
            
            // For regular page load, get paginated results
            $media = $query->latest()->paginate($perPage);
            
            return view('input', compact('media'));
            
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Error fetching media: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memuat data media.'
                ], 500);
            }
            
            return view('input')->with('error', 'Terjadi kesalahan saat memuat data media.');
        }
    }

    /**
     * Upload media baru
     */
    public function store(Request $request)
    {
        try {
            // Enhanced validation with custom messages
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'jenisMedia' => 'required|in:audio,image,video',
                'namaFile'   => 'required|string|max:255',
                // Increase max size to 250MB to accommodate videos
                'file'       => 'required|file|max:256000' // ~250MB
            ], [
                'jenisMedia.required' => 'Jenis media harus dipilih',
                'jenisMedia.in' => 'Jenis media tidak valid',
                'namaFile.required' => 'Nama file harus diisi',
                'namaFile.max' => 'Nama file maksimal 255 karakter',
                'file.required' => 'File harus diunggah',
                'file.file' => 'Unggahan harus berupa file',
                'file.max' => 'Ukuran file maksimal 250MB'
            ]);
            
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first(),
                        'errors'  => $validator->errors(),
                    ], 422);
                }
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            // Get the file and validate mime type based on media type
            $file = $request->file('file');
            $mediaType = $request->jenisMedia;
            
            // Validate file type matches selected media type
            $mimeType = $file->getMimeType();
            $clientMime = $file->getClientMimeType();
            $validMimeTypes = [
                'audio' => [
                    'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg',
                    'audio/x-wav', 'audio/wave', 'audio/aac', 'audio/x-aac',
                    'audio/flac', 'audio/x-flac', 'audio/mp4', 'audio/3gpp', 'audio/3gpp2'
                ],
                'image' => [
                    'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/bmp',
                    'image/x-png', 'image/pjpeg'
                ],
                'video' => [
                    'video/mp4', 'video/mpeg', 'video/quicktime', 'video/webm',
                    'video/3gpp', 'video/3gpp2', 'video/x-msvideo', 'video/x-matroska', 'video/ogg'
                ]
            ];
            
            // Also allow by broad prefix match (e.g., image/*)
            $allowedPrefix = [
                'audio' => 'audio/',
                'image' => 'image/',
                'video' => 'video/',
            ][$mediaType] ?? '';
            $mimeOk = in_array($mimeType, $validMimeTypes[$mediaType])
                || ($mimeType && str_starts_with($mimeType, $allowedPrefix))
                || ($clientMime && str_starts_with($clientMime, $allowedPrefix));

            if (!$mimeOk) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tipe file tidak sesuai dengan jenis media yang dipilih',
                        'errors'  => ['file' => ['Tipe file tidak sesuai dengan jenis media yang dipilih']],
                        'detected_mime' => $mimeType,
                        'client_mime' => $clientMime,
                        'allowed' => $validMimeTypes[$mediaType],
                        'allowed_prefix' => $allowedPrefix,
                    ], 422);
                }
                return redirect()->back()
                    ->withErrors(['file' => 'Tipe file tidak sesuai dengan jenis media yang dipilih'])
                    ->withInput();
            }
            
            // Process the file
            $original = $file->getClientOriginalName();
            $fileName = time() . '_' . $original;
            $filePath = $file->storeAs('media', $fileName, 'public');
            
            if (!$filePath) {
                throw new \Exception('Gagal menyimpan file');
            }
            
            $typeMap = [
                'audio' => 'Audio',
                'image' => 'Gambar',
                'video' => 'Video'
            ];
            
            // Create media record with transaction to ensure data integrity
            $media = \Illuminate\Support\Facades\DB::transaction(function() use ($request, $typeMap, $filePath, $original) {
                return Media::create([
                    'user_id'           => Auth::id(),
                    'name'              => $request->namaFile,
                    'type'              => $typeMap[$request->jenisMedia],
                    'file_path'         => $filePath,
                    'original_filename' => $original,
                    'date'              => now()->toDateString(),
                ]);
            });
            
            // Log the successful upload
            Log::createLog(Auth::id(), 'Upload Media', "Uploaded {$media->type}: {$media->name}");

            // Respond based on request type
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Media berhasil diunggah',
                    'data' => [
                        'id' => $media->id,
                        'name' => $media->name,
                        'type' => $media->type,
                        'file_path' => $media->file_path,
                        'original_filename' => $media->original_filename,
                        'created_at' => $media->created_at,
                    ],
                ]);
            }

            return redirect()
                ->route('dashboard.pegawai')
                ->with('success', 'Media berhasil diupload!');
                
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Error uploading media: ' . $e->getMessage());
            
            // Clean up any uploaded file if it exists
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengunggah media. Silakan coba lagi.'
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah media. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Tandai media untuk tampil di landing page atau sembunyikan dari landing page
     */
    public function toggleLanding(Request $request)
    {
        try {
            $mediaIds = $request->input('media_ids', []);

            if (empty($mediaIds)) {
                return response()->json(['success' => false, 'message' => 'Pilih media terlebih dahulu']);
            }
            
            // Validate that all media IDs are integers
            foreach ($mediaIds as $id) {
                if (!is_numeric($id) || intval($id) != $id) {
                    return response()->json(['success' => false, 'message' => 'ID media tidak valid']);
                }
            }

            // Get the first media to check its current status
            $media = Media::where('id', $mediaIds[0])->where('user_id', Auth::id())->first();
            
            if (!$media) {
                return response()->json(['success' => false, 'message' => 'Media tidak ditemukan']);
            }
            
            // Toggle the show_on_landing status
            $newStatus = !$media->show_on_landing;
            
            // Use a transaction to ensure data integrity
            $count = \Illuminate\Support\Facades\DB::transaction(function() use ($mediaIds, $newStatus) {
                return Media::whereIn('id', $mediaIds)
                    ->where('user_id', Auth::id())
                    ->update(['show_on_landing' => $newStatus]);
            });

            $action = $newStatus ? 'Show on Landing' : 'Hide from Landing';
            Log::createLog(Auth::id(), $action, "{$action} {$count} media");

            return response()->json([
                'success' => true,
                'message' => "{$count} media berhasil " . ($newStatus ? 'ditampilkan di' : 'disembunyikan dari') . " landing page",
                'show_on_landing' => $newStatus
            ]);
            
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Error toggling landing status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status media.'
            ], 500);
        }
    }

    /**
     * Hapus media
     */
    public function destroy($id)
    {
        try {
            // Validate ID
            if (!is_numeric($id)) {
                return response()->json(['success' => false, 'message' => 'ID media tidak valid']);
            }
            
            // Find media with authorization check
            $media = Media::where('id', $id)->where('user_id', Auth::id())->first();
            
            if (!$media) {
                return response()->json(['success' => false, 'message' => 'Media tidak ditemukan']);
            }
            
            // Store media info for logging before deletion
            $mediaType = $media->type;
            $mediaName = $media->name;
            $filePath = $media->file_path;
            
            // Use a transaction to ensure data integrity
            \Illuminate\Support\Facades\DB::transaction(function() use ($media, $filePath) {
                // Delete the media record first
                $media->delete();
                
                // Then delete the file from storage if it exists
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            });
            
            // Log the action
            Log::createLog(Auth::id(), 'Delete Media', "Deleted {$mediaType}: {$mediaName}");
            
            return response()->json(['success' => true, 'message' => 'Media berhasil dihapus']);
            
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Error deleting media: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus media.'
            ], 500);
        }
    }

    /**
     * Search media by name (API endpoint)
     */
    public function search(Request $request)
    {
        try {
            $query = Media::where('user_id', Auth::id());
            
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            
            $media = $query->latest()->get();
            
            return response()->json([
                'success' => true,
                'data' => $media
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error searching media: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari media.'
            ], 500);
        }
    }

    /**
     * Filter media by type (API endpoint)
     */
    public function filter(Request $request)
    {
        try {
            $query = Media::where('user_id', Auth::id());
            
            if ($request->filled('type') && $request->type !== 'all') {
                $query->where('type', ucfirst(strtolower($request->type)));
            }
            
            $media = $query->latest()->get();
            
            return response()->json([
                'success' => true,
                'data' => $media
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error filtering media: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memfilter media.'
            ], 500);
        }
    }


}
