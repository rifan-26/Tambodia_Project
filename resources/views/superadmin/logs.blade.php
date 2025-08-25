@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <!-- Header with Filters -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">System Activity Logs</h2>
                <p class="text-sm text-gray-600 mt-1">Monitor all user activities (Auto-deleted after 24 hours)</p>
            </div>
            <button onclick="refreshLogs()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-sync-alt mr-2"></i> Refresh
            </button>
        </div>
        
        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by User</label>
                <select id="userFilter" onchange="filterLogs()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Action</label>
                <input type="text" id="actionFilter" onchange="filterLogs()" placeholder="Search actions..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" id="dateFrom" onchange="filterLogs()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" id="dateTo" onchange="filterLogs()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
    </div>
    
    <!-- Logs Table Container (Scrollable) -->
    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <div class="max-h-[600px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Timestamp
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Time Remaining
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="logsTableBody">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 log-row" 
                            data-user="{{ $log->user_id }}" 
                            data-action="{{ strtolower($log->action) }}"
                            data-date="{{ $log->created_at->format('Y-m-d') }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-400 mr-2"></i>
                                    {{ $log->created_at->format('M d, Y H:i:s') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $log->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->user->role === 'superadmin' ? 'Super Admin' : 'Employee' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionClass = match(true) {
                                        str_contains(strtolower($log->action), 'create') => 'bg-green-100 text-green-800',
                                        str_contains(strtolower($log->action), 'update') => 'bg-blue-100 text-blue-800',
                                        str_contains(strtolower($log->action), 'delete') => 'bg-red-100 text-red-800',
                                        str_contains(strtolower($log->action), 'upload') => 'bg-purple-100 text-purple-800',
                                        str_contains(strtolower($log->action), 'login') => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $actionClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $log->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $hoursRemaining = 24 - $log->created_at->diffInHours(now());
                                    $timeClass = $hoursRemaining < 2 ? 'text-red-600' : 
                                                ($hoursRemaining < 6 ? 'text-yellow-600' : 'text-green-600');
                                @endphp
                                <span class="{{ $timeClass }}">
                                    <i class="fas fa-hourglass-half mr-1"></i>
                                    {{ $hoursRemaining > 0 ? $hoursRemaining . ' hours' : 'Expiring soon' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>No activity logs found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="p-6 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $logs->firstItem() ?? 0 }}</span> to 
                <span class="font-medium">{{ $logs->lastItem() ?? 0 }}</span> of 
                <span class="font-medium">{{ $logs->total() }}</span> results
            </div>
            <div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-full bg-green-100 p-3">
                    <i class="fas fa-chart-line text-green-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Activities Today</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $logs->where('created_at', '>=', now()->startOfDay())->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-full bg-blue-100 p-3">
                    <i class="fas fa-upload text-blue-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Media Uploads</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $logs->where('action', 'Upload Media')->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-full bg-yellow-100 p-3">
                    <i class="fas fa-users text-yellow-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Active Users</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $logs->unique('user_id')->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-full bg-red-100 p-3">
                    <i class="fas fa-trash text-red-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Deletions</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $logs->filter(function($log) { return str_contains(strtolower($log->action), 'delete'); })->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterLogs() {
    const userFilter = document.getElementById('userFilter').value;
    const actionFilter = document.getElementById('actionFilter').value.toLowerCase();
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    const rows = document.querySelectorAll('.log-row');
    
    rows.forEach(row => {
        let show = true;
        
        if (userFilter && row.dataset.user !== userFilter) show = false;
        if (actionFilter && !row.dataset.action.includes(actionFilter)) show = false;
        if (dateFrom && row.dataset.date < dateFrom) show = false;
        if (dateTo && row.dataset.date > dateTo) show = false;
        
        row.style.display = show ? '' : 'none';
    });
}

function refreshLogs() {
    location.reload();
}

// Auto-refresh every 30 seconds
setInterval(function() {
    const badge = document.createElement('div');
    badge.className = 'fixed top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-lg text-sm';
    badge.textContent = 'Auto-refreshing...';
    document.body.appendChild(badge);
    
    setTimeout(() => {
        badge.remove();
        location.reload();
    }, 1000);
}, 30000);
</script>
@endpush
