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
        // Middleware auth dan role:superadmin sudah diterapkan di routes/web.php
    }

    public function adminManagement()
    {
        // Get all users to manage (both roles)
        $admins = User::orderBy('created_at', 'desc')->get();
        
        // Get current authenticated user
        $currentUser = auth()->user();
        
        return view('superakun', compact('admins', 'currentUser'));
    }

    public function storeAdmin(Request $request)
    {
        try {
            // Log request data for debugging
            \Illuminate\Support\Facades\Log::info('Admin store request data:', $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:superadmin,pegawai',
            ]);
            
            \Illuminate\Support\Facades\Log::info('Validation passed, creating admin');
            
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
            
            \Illuminate\Support\Facades\Log::info('Admin created with ID: ' . $admin->id);

            // Log activity
            Log::createLog(Auth::id(), 'Create Admin', "Created admin account: {$admin->email}");

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil ditambahkan!',
                'admin' => $admin
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating admin: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:superadmin,pegawai',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
            'role' => $request->role,
        ]);

        // Log activity
        Log::createLog(Auth::id(), 'Update Admin', "Updated admin account: {$admin->email}");

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil diupdate!',
            'admin' => $admin->fresh(),
        ]);
    }

    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        // Log before delete
        Log::createLog(Auth::id(), 'Delete Admin', "Deleted admin account: {$admin->email}");

        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus!',
            'admin' => $admin,
        ]);
    }
}
