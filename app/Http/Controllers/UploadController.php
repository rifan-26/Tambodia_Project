<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis_media' => 'required|string',
            'file_upload' => 'required|file|max:20480', // max 20MB
            'nama_file'   => 'required|string|max:255',
        ]);

        // Simpan file ke storage/app/public/uploads
        $path = $request->file('file_upload')->store('uploads', 'public');

        return back()->with('success', 'File berhasil diunggah ke: ' . $path);
    }
}
