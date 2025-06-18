@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">Admin Dashboard</h2>

    {{-- Cards Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Hours</p>
            <h3 class="text-3xl font-bold text-indigo-600 mt-2">120</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Requests</p>
            <h3 class="text-3xl font-bold text-green-600 mt-2">45</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Users</p>
            <h3 class="text-3xl font-bold text-orange-500 mt-2">10</h3>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h4 class="text-lg font-semibold mb-4 text-gray-700">Request Trend</h4>
        <canvas id="requestChart" height="120"></canvas>
    </div>

    {{-- Data Table --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold mb-4 text-gray-700">Recent Requests</h4>
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
                <tr class="border-b">
                    <td class="px-4 py-2">user123</td>
                    <td class="px-4 py-2">Incident</td>
                    <td class="px-4 py-2">2.5</td>
                    <td class="px-4 py-2">Printer issue</td>
                    <td class="px-4 py-2">2025-06-14</td>
                </tr>
                <tr class="border-b">
                    <td class="px-4 py-2">user456</td>
                    <td class="px-4 py-2">Service Request</td>
                    <td class="px-4 py-2">1</td>
                    <td class="px-4 py-2">Install software</td>
                    <td class="px-4 py-2">2025-06-15</td>
                </tr>
                <!-- More rows -->
            </tbody>
        </table>
    </div>
</div>

{{-- Chart JS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('requestChart').getContext('2d');
    const requestChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jun 1', 'Jun 2', 'Jun 3', 'Jun 4', 'Jun 5', 'Jun 6', 'Jun 7'],
            datasets: [{
                label: 'Hours per Day',
                data: [2, 3, 1.5, 4, 2.5, 3, 2],
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
