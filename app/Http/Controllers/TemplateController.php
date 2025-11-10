<?php

namespace App\Http\Controllers;

use App\Models\LayoutTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = LayoutTemplate::with('creator')
            ->orderBy('updated_at', 'desc')
            ->paginate(12);

        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = new LayoutTemplate();
        $template->name = 'Template Baru';
        $template->grid_type = '2x2';
        $template->grid_config = [];
        $template->elements = [];
        
        return view('admin.templates.builder', compact('template'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'grid_type' => 'required|string',
                'grid_config' => 'required|array',
                'elements' => 'required|array'
            ]);

            $template = new LayoutTemplate();
            $template->name = $validated['name'];
            $template->grid_type = $validated['grid_type'];
            $template->grid_config = $validated['grid_config'];
            $template->elements = $validated['elements'];
            $template->is_active = false;
            $template->created_by = Auth::id();
            $template->save();

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil disimpan',
                'template_id' => $template->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = LayoutTemplate::findOrFail($id);
        return view('admin.templates.builder', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $template = LayoutTemplate::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'grid_type' => 'required|string',
                'grid_config' => 'required|array',
                'elements' => 'required|array'
            ]);

            $template->name = $validated['name'];
            $template->grid_type = $validated['grid_type'];
            $template->grid_config = $validated['grid_config'];
            $template->elements = $validated['elements'];
            $template->save();

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $template = LayoutTemplate::findOrFail($id);
            
            // Prevent deletion of active template
            if ($template->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Template aktif tidak dapat dihapus. Pilih template lain terlebih dahulu.'
                ], 400);
            }
            
            // Delete thumbnail if exists
            if ($template->thumbnail_path && Storage::exists($template->thumbnail_path)) {
                Storage::delete($template->thumbnail_path);
            }
            
            // Delete associated images
            $mediaIds = $template->getUsedMediaIds();
            foreach ($mediaIds as $mediaId) {
                $media = Media::find($mediaId);
                if ($media && Storage::exists($media->file_path)) {
                    // Only delete if not used by other templates
                    $usedByOthers = LayoutTemplate::where('id', '!=', $template->id)
                        ->get()
                        ->filter(function($t) use ($mediaId) {
                            return in_array($mediaId, $t->getUsedMediaIds());
                        })
                        ->count();
                    
                    if ($usedByOthers == 0) {
                        Storage::delete($media->file_path);
                        $media->delete();
                    }
                }
            }
            
            // Soft delete template
            $template->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Template berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activate template
     */
    public function activate($id)
    {
        try {
            $template = LayoutTemplate::findOrFail($id);
            $template->activate();

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil diaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Duplicate template
     */
    public function duplicate($id)
    {
        try {
            $template = LayoutTemplate::findOrFail($id);
            
            $newTemplate = $template->replicate();
            $newTemplate->name = $template->name . ' (Copy)';
            $newTemplate->is_active = false;
            $newTemplate->created_by = Auth::id();
            $newTemplate->save();

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil diduplikasi',
                'template_id' => $newTemplate->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menduplikasi template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload image for template
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120' // 5MB
            ]);

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('templates/images', $filename, 'public');

            // Create media record
            $media = new \App\Models\Media();
            $media->name = $filename;
            $media->type = 'Gambar';
            $media->file_path = 'storage/' . $path;
            $media->uploaded_by = Auth::id();
            $media->save();

            return response()->json([
                'success' => true,
                'path' => asset('storage/' . $path),
                'mediaId' => $media->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload gambar: ' . $e->getMessage()
            ], 500);
        }
    }
}
