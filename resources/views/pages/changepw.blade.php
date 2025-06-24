@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Change Password</h2>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="change-password-form" method="POST" action="{{ route('changepassword.submit') }}" class="space-y-4">
        @csrf

        <!-- Old Password -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Old Password</label>
            <input type="password" name="old_password" required class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500">
        </div>

        <!-- New Password -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">New Password</label>
            <input type="password" name="new_password" required class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500">
        </div>

        <!-- Confirm New Password -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" required class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Change Password
            </button>
        </div>
    </form>
</div>
@endsection
