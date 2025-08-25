<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // model default laravel

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = User::query()->where('role', 'admin');

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $admins = $query->orderBy('created_at', 'desc')->get();

        return view('superadmin.dashboard', [
            'admins' => $admins,
            'keyword' => $keyword
        ]);
    }
}
