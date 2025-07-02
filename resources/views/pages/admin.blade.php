@extends('layouts.app')

@section('content')
@php
use Carbon\Carbon;
@endphp

<div class="max-w-7xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">Admin Dashboard</h2>

    {{-- User Filter for Chart --}}
    <form method="GET" action="{{ route('admindashboard') }}" class="mb-6">
        <label class="block text-sm font-medium text-gray-600 mb-1">Filter by User</label>
        <select name="filter_user" onchange="this.form.submit()" class="w-64 border rounded-md px-3 py-2">
            <option value="">All Users</option>
            @foreach ($allUsers as $userId)
                <option value="{{ $userId }}" {{ request('filter_user') == $userId ? 'selected' : '' }}>
                    {{ $userId }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Cards Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Hours</p>
            <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalHours }}</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Requests</p>
            <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $totalRequests }}</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Users</p>
            <h3 class="text-3xl font-bold text-orange-500 mt-2">{{ $totalUsers }}</h3>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h4 class="text-lg font-semibold mb-4 text-gray-700">Request Trend</h4>
        <canvas id="requestChart" height="120"></canvas>
    </div>

    {{-- Data Table --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold mb-4 text-gray-700">Recent Requests (Today)</h4>
        <table class="w-full table-auto text-left text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">User ID</th>
                    <th class="px-4 py-2">Request Type</th>
                    <th class="px-4 py-2">Hours</th>
                    <th class="px-4 py-2">Note</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach($recentRequests as $req)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $req['user_id'] }}</td>
                        <td class="px-4 py-2">{{ $req['request_type'] }}</td>
                        <td class="px-4 py-2">{{ $req['hours'] }}</td>
                        <td class="px-4 py-2">{{ $req['note'] }}</td>
                        <td class="px-4 py-2">{{ Carbon::parse($req['created_at'])->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Chart JS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const requestChart = new Chart(document.getElementById('requestChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Total Hours',
                data: {!! json_encode($chartValues) !!},
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Total Request Hours Per Day'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
