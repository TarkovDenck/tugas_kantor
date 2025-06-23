@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">User Management</h2>

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

    <!-- Form Tambah User -->
    <form method="POST" action="{{ url('/add-user') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-6">
        @csrf
        <div>
            <label class="block text-sm text-gray-600 mb-1">User ID</label>
            <input type="text" name="user_id" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter user ID">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500" placeholder="Enter password">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Role</label>
            <select name="role" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500">
                <option value="technician">Technician</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                Add User
            </button>
        </div>
    </form>

    <!-- Table User -->
    @if(isset($users) && count($users) > 0)
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full border border-gray-300 text-sm rounded-md">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">User ID</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Created At</th>
                    <th class="px-4 py-2 border">Updated At</th>
                    <th class="px-4 py-2 border">Action</th> {{-- Kolom Aksi --}}
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $user['user_id'] }}</td>
                    <td class="border px-4 py-2">{{ $user['role'] }}</td>
                    <td class="border px-4 py-2">{{ $user['created_at'] }}</td>
                    <td class="border px-4 py-2">{{ $user['updated_at'] }}</td>
                    <td class="border px-4 py-2 text-center">
                        <button 
                            type="button"
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs mr-2"
                            onclick="openEditModal('{{ $user['user_id'] }}')"
                        >
                            Edit
                        </button>

                        <form method="POST" action="{{ route('user.delete', $user['user_id']) }}" onsubmit="return confirm('Are you sure to delete this user?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-gray-500 mt-6 italic">Belum ada user tersimpan.</p>
    @endif

</div>

<!-- Modal Edit Password -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Edit User Password</h3>
        <form method="POST" id="editForm">
            @csrf
            <input type="hidden" name="user_id" id="editUserId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                <input type="password" name="password" id="editPassword" class="w-full border rounded-md px-3 py-2" required>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</div>


<script>
    function openEditModal(userId) {
        document.getElementById('editUserId').value = userId;
        document.getElementById('editForm').action = '/edit-user/' + userId;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>

@endsection