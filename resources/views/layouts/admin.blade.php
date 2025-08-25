<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom Styles -->
    @stack('styles')
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="transition-all duration-300 bg-gradient-to-b from-indigo-600 to-indigo-800 text-white flex-shrink-0">
            <div class="flex items-center justify-between p-4">
                <h2 :class="!sidebarOpen && 'hidden'" class="text-2xl font-bold">Admin Panel</h2>
                <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-indigo-700 p-2 rounded-lg transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <!-- User Info -->
            <div class="px-4 py-3 border-t border-indigo-500">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-400 rounded-full flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <div :class="!sidebarOpen && 'hidden'">
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-200">{{ Auth::user()->role === 'superadmin' ? 'Super Admin' : 'Employee' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6">
                @if(Auth::user()->role === 'superadmin')
                    <a href="{{ route('dashboard.superadmin') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('dashboard.superadmin') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.management') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('admin.management') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-users-cog w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Manage Admins</span>
                    </a>
                    <a href="{{ route('admin.logs') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('admin.logs') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-history w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Activity Logs</span>
                    </a>
                    <a href="{{ route('media.input') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('media.input') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-photo-video w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Media Files</span>
                    </a>
                @else
                    <a href="{{ route('dashboard.pegawai') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('dashboard.pegawai') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('media.input') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('media.input') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-upload w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Upload Media</span>
                    </a>
                    <a href="{{ route('schedule.index') }}" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition {{ request()->routeIs('schedule.index') ? 'bg-indigo-700 border-l-4 border-white' : '' }}">
                        <i class="fas fa-calendar-alt w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Schedule</span>
                    </a>
                @endif
                
                <a href="{{ route('landing') }}" target="_blank" class="flex items-center px-4 py-3 hover:bg-indigo-700 transition">
                    <i class="fas fa-external-link-alt w-6"></i>
                    <span :class="!sidebarOpen && 'hidden'" class="ml-3">View Landing Page</span>
                </a>
            </nav>
            
            <!-- Logout -->
            <div class="absolute bottom-0 w-full">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 hover:bg-red-600 transition">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span :class="!sidebarOpen && 'hidden'" class="ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ now()->format('l, F j, Y') }}</span>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <hr class="my-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    <p class="font-medium">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif
                
                @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p class="font-medium">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Global JavaScript -->
    <script>
        // CSRF Token for AJAX requests
        window.axios = {
            defaults: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        };
    </script>
    
    @stack('scripts')
</body>
</html>
