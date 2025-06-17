@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Change Password</h2>

    <form id="change-password-form" class="space-y-4">
        <!-- User ID -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">User ID</label>
            <input type="text" id="user-id" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter user ID">
        </div>

        <!-- Old Password -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Old Password</label>
            <input type="password" id="old-password" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter old password">
        </div>

        <!-- New Password -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">New Password</label>
            <input type="password" id="new-password" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter new password">
        </div>

        <!-- Retry New Password -->
        <div>
            <label class="block text-sm text-gray-600 mb-1">Confirm New Password</label>
            <input type="password" id="retry-password" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Confirm new password">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="button" onclick="changePassword()" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Change Password
            </button>
        </div>
    </form>
</div>

<script>
    function changePassword() {
        const userId = document.getElementById('user-id').value.trim();
        const oldPwd = document.getElementById('old-password').value.trim();
        const newPwd = document.getElementById('new-password').value.trim();
        const retryPwd = document.getElementById('retry-password').value.trim();

        if (!userId || !oldPwd || !newPwd || !retryPwd) {
            alert("All fields are required.");
            return;
        }

        if (newPwd !== retryPwd) {
            alert("New password and confirmation do not match.");
            return;
        }

        alert(`Password for user "${userId}" changed successfully! (simulasi)`);

        // Reset form
        document.getElementById('change-password-form').reset();
    }
</script>
@endsection
