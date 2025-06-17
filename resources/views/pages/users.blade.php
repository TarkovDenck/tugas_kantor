@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">User Management</h2>

    <!-- Form Tambah User -->
    <form id="user-form" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-6">
        <div>
            <label class="block text-sm text-gray-600 mb-1">User ID</label>
            <input type="text" id="user-id" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter user ID">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Password</label>
            <input type="password" id="user-password" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter password">
        </div>
        <div>
            <button type="button" onclick="addUser()" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Add User
            </button>
        </div>
    </form>

    <!-- Table User -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm rounded-md">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">User ID</th>
                    <th class="px-4 py-2 border">Password</th>
                    <th class="px-4 py-2 border">Created At</th>
                    <th class="px-4 py-2 border">Updated At</th>
                </tr>
            </thead>
            <tbody id="user-table">
                <!-- Baris user akan ditambahkan di sini -->
            </tbody>
        </table>
    </div>
</div>

<script>
    let users = [];

    function formatDateTime(date) {
        return date.toLocaleString('en-GB', {
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    function addUser() {
        const id = document.getElementById('user-id').value.trim();
        const pwd = document.getElementById('user-password').value.trim();

        if (!id || !pwd) {
            alert("User ID dan Password harus diisi.");
            return;
        }

        const now = new Date();

        // Cari apakah user sudah ada (simulasi update)
        const existing = users.find(user => user.id === id);
        if (existing) {
            existing.pwd = pwd;
            existing.updated_at = formatDateTime(now);
        } else {
            users.push({
                id,
                pwd,
                created_at: formatDateTime(now),
                updated_at: formatDateTime(now)
            });
        }

        renderTable();

        // Reset form
        document.getElementById('user-id').value = '';
        document.getElementById('user-password').value = '';
    }

    function renderTable() {
        const table = document.getElementById('user-table');
        table.innerHTML = '';

        users.forEach((user, index) => {
            table.innerHTML += `
                <tr>
                    <td class="border px-4 py-2 text-center">${index + 1}</td>
                    <td class="border px-4 py-2">${user.id}</td>
                    <td class="border px-4 py-2">${'*'.repeat(user.pwd.length)}</td>
                    <td class="border px-4 py-2">${user.created_at}</td>
                    <td class="border px-4 py-2">${user.updated_at}</td>
                </tr>
            `;
        });
    }
</script>
@endsection
