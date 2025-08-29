<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\LayoutSetting;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    public function index()
    {
        // Get images and videos for the layout selector
        $media = Media::where('user_id', Auth::id())
            ->whereIn('type', ['Gambar', 'Video'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get current layout settings
        $layoutSetting = LayoutSetting::where('user_id', Auth::id())->first();
        $description = $layoutSetting ? $layoutSetting->description : 'Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.';

        // Get current layout images
        $layoutImages = Media::where('user_id', Auth::id())
            ->where('show_on_landing', true)
            ->orderBy('layout_order', 'asc')
            ->get();

        return view('layout', compact('media', 'description', 'layoutImages'));
    }

    public function updateBackground(Request $request)
    {
        try {
            // Allow null background_image_id for clearing background
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'background_image_id' => 'nullable|integer|exists:media,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            // Get or create layout setting
            $layoutSetting = LayoutSetting::firstOrCreate(
                ['user_id' => Auth::id()],
                ['description' => 'Default description']
            );

            // Update background image (can be null to clear)
            $layoutSetting->background_image_id = $request->background_image_id;
            $layoutSetting->save();

            $message = $request->background_image_id ? 'Background berhasil diperbarui' : 'Background berhasil dihapus';
            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateLayout(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'description' => 'nullable|string|max:1000',
                'images' => 'nullable|array', // Allow empty array
                'images.*.position' => 'required|integer|min:1|max:6',
                'images.*.image_id' => 'required|integer|exists:media,id',
                'images.*.order' => 'required|integer|min:1'
            ], [
                'description.max' => 'Deskripsi maksimal 1000 karakter',
                'images.array' => 'Data gambar harus berupa array',
                'images.*.position.required' => 'Posisi gambar harus disediakan',
                'images.*.position.integer' => 'Posisi gambar harus berupa angka',
                'images.*.position.min' => 'Posisi gambar minimal 1',
                'images.*.position.max' => 'Posisi gambar maksimal 6',
                'images.*.image_id.required' => 'ID gambar harus disediakan',
                'images.*.image_id.integer' => 'ID gambar harus berupa angka',
                'images.*.image_id.exists' => 'Gambar tidak ditemukan',
                'images.*.order.required' => 'Urutan harus disediakan',
                'images.*.order.integer' => 'Urutan harus berupa angka',
                'images.*.order.min' => 'Urutan minimal 1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            $description = $request->input('description', '');
            $images = $request->input('images', []); // Default to empty array
            
            // Use transaction to ensure data integrity
            DB::transaction(function() use ($description, $images) {
                // First, reset all media to not show on landing and clear layout order
                Media::where('user_id', Auth::id())
                    ->update([
                        'show_on_landing' => false,
                        'layout_order' => null
                    ]);
                
                // Then update the selected images (if any)
                if (!empty($images)) {
                    foreach ($images as $imageData) {
                        Media::where('id', $imageData['image_id'])
                            ->where('user_id', Auth::id())
                            ->update([
                                'show_on_landing' => true,
                                'layout_order' => $imageData['order']
                            ]);
                    }
                }
                
                // Store layout description in layout_settings table
                LayoutSetting::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['description' => $description]
                );
            });

            // Log the action
            $imageCount = count($images);
            $logMessage = $imageCount > 0 
                ? "Updated landing page layout with {$imageCount} images" 
                : 'Updated landing page layout (no media)';
            Log::createLog(Auth::id(), 'Update Layout', $logMessage);

            $responseMessage = $imageCount > 0 
                ? 'Layout berhasil disimpan dan diterapkan ke landing page!' 
                : 'Layout berhasil disimpan (tanpa media)!';
            
            return response()->json([
                'success' => true,
                'message' => $responseMessage
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating layout: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan layout'
            ], 500);
        }
    }
}
