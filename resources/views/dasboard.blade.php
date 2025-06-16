@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Total Hours</h2>

            <div class="p-2 bg-indigo-100 rounded-full">
                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Tanggal Filter -->
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                <div>
                    <label class="text-sm text-gray-600">Start Date</label>
                    <input type="date" name="start_date" class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="text-sm text-gray-600">End Date</label>
                    <input type="date" name="end_date" class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Jam Total Placeholder -->
            <p class="text-4xl font-extrabold text-indigo-600 text-center">120</p>
        </form>
    </div>

    <!-- Tombol Tracking -->
    <button class="mt-4 text-sm text-white bg-indigo-600 hover:bg-indigo-700 transition px-4 py-2 rounded-md w-full">
        Track Hours
    </button>
</div>


<!-- Total Request Card -->
<div class="bg-white rounded-lg shadow-lg p-6 mt-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Total Requests</h2>
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
        </div>

        <!-- Placeholder Total Requests -->
        <p class="text-4xl font-extrabold text-green-600 text-center">45</p>
    </div>

    <!-- Optional Refresh Button -->
    <button class="mt-4 text-sm text-white bg-green-600 hover:bg-green-700 transition px-4 py-2 rounded-md w-full">
        Refresh Data
    </button>
</div>
<div class="bg-white rounded-lg shadow-lg p-6 mt-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h16zM9 10a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </div>
        </div>

        <!-- Placeholder Total Users -->
        <p class="text-4xl font-extrabold text-blue-600 text-center">120</p>
    </div>

    <!-- Optional Refresh Button -->
    <button class="mt-4 text-sm text-white bg-blue-600 hover:bg-blue-700 transition px-4 py-2 rounded-md w-full">
        Refresh Data
    </button>
</div>

@endsection
