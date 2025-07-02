@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">User Profile</h2>

    <div class="space-y-4 text-gray-700">
        <!-- User ID -->
        <div>
            <label class="block text-sm font-medium text-gray-600">User ID</label>
            <input type="text" readonly class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                   value="{{ $userId }}">
        </div>

        <!-- Project Name (hanya ditampilkan jika ada) -->
        @if(!empty($profile['project']))
        <div>
            <label class="block text-sm font-medium text-gray-600">Project</label>
            <input type="text" readonly class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                   value="{{ $profile['project'] }}">
        </div>
        @endif

        <!-- Project ID (hanya ditampilkan jika ada) -->
        @if(!empty($profile['project_id']))
        <div>
            <label class="block text-sm font-medium text-gray-600">Project ID</label>
            <input type="text" readonly class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                   value="{{ $profile['project_id'] }}">
        </div>
        @endif
    </div>
</div>
@endsection
