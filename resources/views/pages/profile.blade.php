@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">User Profile</h2>

    <div class="space-y-4 text-gray-700">
        <!-- User ID -->
        <div>
            <label class="block text-sm font-medium text-gray-600">User ID</label>
            <input type="text" readonly class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-100" value="{{ Auth::user()->id ?? '12345' }}">
        </div>

        <!-- Project Name -->
        <div>
            <label class="block text-sm font-medium text-gray-600">Project</label>
            <input type="text" class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2" placeholder="Enter project name">
        </div>

        <!-- Project ID -->
        <div>
            <label class="block text-sm font-medium text-gray-600">Project ID</label>
            <input type="text" class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2" placeholder="Enter project ID">
        </div>

        <!-- Update Button -->
        <div>
            <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Save Profile
            </button>
        </div>
    </div>
</div>
@endsection
