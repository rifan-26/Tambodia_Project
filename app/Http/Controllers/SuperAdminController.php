<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function adminManagement()
    {
        $admins = User::where('role', 'pegawai')->orderBy('created_at', 'desc')->get();
        return view('superakun', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        // Log activity
        Log::createLog(Auth::id(), 'Create Admin', "Created admin account: {$admin->email}");

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil ditambahkan!',
            'admin' => $admin
        ]);
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::where('role', 'pegawai')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        // Log activity
        Log::createLog(Auth::id(), 'Update Admin', "Updated admin account: {$admin->email}");

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil diupdate!'
        ]);
    }

    public function destroyAdmin($id)
    {
        $admin = User::where('role', 'pegawai')->findOrFail($id);
        
        // Log before delete
        Log::createLog(Auth::id(), 'Delete Admin', "Deleted admin account: {$admin->email}");

        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus!'
        ]);
    }
}

