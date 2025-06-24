@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Request</h2>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="text-left px-4 py-2">Request ID</th>
                    <th class="text-left px-4 py-2">User ID</th>
                    <th class="text-left px-4 py-2">Description</th>
                    <th class="text-left px-4 py-2">Status</th>
                    <th class="text-left px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <!-- Dummy data -->
                <tr>
                    <td class="px-4 py-2">REQ001</td>
                    <td class="px-4 py-2">U001</td>
                    <td class="px-4 py-2">Laptop issue</td>
                    <td class="px-4 py-2">Pending</td>
                    <td class="px-4 py-2">
                        <button 
                            class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                            onclick="openEditModal('REQ001', 'U001', 'Laptop issue', 'Pending')"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">REQ002</td>
                    <td class="px-4 py-2">U002</td>
                    <td class="px-4 py-2">Monitor replacement</td>
                    <td class="px-4 py-2">Approved</td>
                    <td class="px-4 py-2">
                        <button 
                            class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                            onclick="openEditModal('REQ002', 'U002', 'Monitor replacement', 'Approved')"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Edit Request</h3>
        <form id="editRequestForm" method="POST">
            @csrf
            <input type="hidden" name="request_id" id="modalRequestId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">User ID</label>
                <input type="text" name="user_id" id="modalUserId" class="w-full border rounded-md px-3 py-2" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Description</label>
                <input type="text" name="description" id="modalDescription" class="w-full border rounded-md px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                <select name="status" id="modalStatus" class="w-full border rounded-md px-3 py-2">
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, userId, description, status) {
        document.getElementById('modalRequestId').value = id;
        document.getElementById('modalUserId').value = userId;
        document.getElementById('modalDescription').value = description;
        document.getElementById('modalStatus').value = status;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
