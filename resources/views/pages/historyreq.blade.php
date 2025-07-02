@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">History Request Log</h2>

    <!-- Filter Date + User --> 
    <form method="GET" action="{{ route('historyreq.view') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Start Date</label>
            <input type="date" name="from" value="{{ request('from') }}" class="w-full border px-3 py-2 rounded-md">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">End Date</label>
            <input type="date" name="to" value="{{ request('to') }}" class="w-full border px-3 py-2 rounded-md">
        </div>

        @if(session('role') === 'admin')
        <div>
            <label class="block text-sm text-gray-600 mb-1">Filter User</label>
            <select name="filter_user" class="w-full border px-3 py-2 rounded-md">
                <option value="">All Users</option>
                @foreach($allUsers as $user)
                    <option value="{{ $user }}" {{ request('filter_user') == $user ? 'selected' : '' }}>{{ $user }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="flex items-end">
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Filter
            </button>
        </div>
    </form>


    <!-- Table -->
    <div class="overflow-x-auto mb-4">
        <table class="min-w-full bg-white border rounded-md text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Action</th>
                    <th class="px-4 py-2 border">User ID</th> <!-- Tambahan -->
                    <th class="px-4 py-2 border">Request Type</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Hours</th>
                    <th class="px-4 py-2 border">Note</th>
                </tr>
            </thead>
            <tbody>
                @php $totalHours = 0; @endphp
                @forelse ($logs as $log)
                    @php $totalHours += isset($log['hours']) ? floatval($log['hours']) : 0; @endphp
                    <tr>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($log['date'])->format('Y-m-d') }}</td>
                        <td class="border px-4 py-2">{{ $log['action'] }}</td>
                        <td class="border px-4 py-2">{{ $log['user_id'] ?? '-' }}</td> <!-- Tambahan -->
                        <td class="border px-4 py-2">{{ $log['request_type'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $log['quantity'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $log['hours'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $log['note'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500 italic border">No request history found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>
@endsection
