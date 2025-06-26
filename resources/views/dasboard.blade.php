@extends('layouts.app')

@section('content')

{{-- Total Hours Card --}}
<div class="bg-white rounded-lg shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Total Hours</h2>
            <div class="p-2 bg-indigo-100 rounded-full">
                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('dashboard') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-sm text-gray-600">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
            </div>

            <!-- Total Hours -->
            <p class="text-4xl font-extrabold text-indigo-600 text-center">{{ $totalHours }}</p>

            <!-- Submit Button (Tetap dalam form) -->
            <button type="submit" class="mt-4 text-sm text-white bg-indigo-600 hover:bg-indigo-700 transition px-4 py-2 rounded-md w-full">
                Track Hours
            </button>
        </form>
    </div>
</div>




{{-- Total Request Card --}}
<div class="bg-white rounded-lg shadow-lg p-6 mt-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Total Requests</h2>
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
        </div>

        <p class="text-4xl font-extrabold text-green-600 text-center">{{ $totalRequests }}</p>
    </div>

    <button class="mt-4 text-sm text-white bg-green-600 hover:bg-green-700 transition px-4 py-2 rounded-md w-full">
        Refresh Data
    </button>
</div>

{{-- Total Quantity Card --}}
<div class="bg-white rounded-lg shadow-lg p-6 mt-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-300">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Total Quantity</h2>
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h1l1 9h14l1-9h1M4 10V6a1 1 0 011-1h14a1 1 0 011 1v4" />
                </svg>
            </div>
        </div>

        <p class="text-4xl font-extrabold text-yellow-600 text-center">{{ $totalQuantity }}</p>
    </div>

    <button class="mt-4 text-sm text-white bg-yellow-600 hover:bg-yellow-700 transition px-4 py-2 rounded-md w-full">
        Refresh Data
    </button>
</div>

@endsection
