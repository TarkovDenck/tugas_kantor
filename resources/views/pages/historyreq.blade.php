@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">History Request</h2>

    <!-- Filter Date -->
    <form id="filter-form" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Start Date</label>
            <input type="date" id="start-date" class="w-full border px-3 py-2 rounded-md focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">End Date</label>
            <input type="date" id="end-date" class="w-full border px-3 py-2 rounded-md focus:ring-indigo-500">
        </div>
        <div class="flex items-end">
            <button type="button" onclick="filterRequests()" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Filter
            </button>
        </div>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto mb-4">
        <table class="min-w-full bg-white border rounded-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Request Type</th>
                    <th class="px-4 py-2 border">Number</th>
                    <th class="px-4 py-2 border">Hours</th>
                    <th class="px-4 py-2 border">Note</th>
                </tr>
            </thead>
            <tbody id="history-table">
                <!-- Data baris akan muncul di sini -->
            </tbody>
        </table>
    </div>

    <!-- Total Jam -->
    <div class="text-right text-lg font-semibold text-indigo-700">
        Total Hours: <span id="total-hours">0</span>
    </div>
</div>

<script>
    // Simulasi data history
    const requestHistory = [
        { date: '2025-06-15', type: 'Incident', number: 3, hours: 1.5, note: 'Network issue' },
        { date: '2025-06-15', type: 'Internal Support', number: 2, hours: 2.0, note: 'Printer setup' },
        { date: '2025-06-16', type: 'Service Request', number: 1, hours: 1.0, note: 'Install software' },
        { date: '2025-06-17', type: 'Incident', number: 5, hours: 2.5, note: 'Email problem' }
    ];

    function filterRequests() {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const table = document.getElementById('history-table');
        const totalEl = document.getElementById('total-hours');

        let filtered = requestHistory;

        if (startDate && endDate) {
            filtered = requestHistory.filter(item => {
                return item.date >= startDate && item.date <= endDate;
            });
        }

        // Tampilkan data
        table.innerHTML = '';
        let total = 0;

        filtered.forEach(item => {
            total += parseFloat(item.hours);
            table.innerHTML += `
                <tr>
                    <td class="px-4 py-2 border text-sm">${item.date}</td>
                    <td class="px-4 py-2 border text-sm">${item.type}</td>
                    <td class="px-4 py-2 border text-sm">${item.number}</td>
                    <td class="px-4 py-2 border text-sm">${item.hours}</td>
                    <td class="px-4 py-2 border text-sm">${item.note}</td>
                </tr>
            `;
        });

        totalEl.innerText = total.toFixed(1);
    }

    // Load semua saat halaman dibuka
    window.onload = filterRequests;
</script>
@endsection
