@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Manage User Profiles</h2>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="text-left px-4 py-2">User ID</th>
                    <th class="text-left px-4 py-2">Project</th>
                    <th class="text-left px-4 py-2">Project ID</th>
                    <th class="text-left px-4 py-2">Created At</th>
                    <th class="text-left px-4 py-2">Updated At</th>
                    <th class="text-left px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <!-- Dummy row -->
                <tr>
                    <td class="px-4 py-2">U001</td>
                    <td class="px-4 py-2">Internal System</td>
                    <td class="px-4 py-2">PRJ001</td>
                    <td class="px-4 py-2">2025-06-10</td>
                    <td class="px-4 py-2">2025-06-15</td>
                    <td class="px-4 py-2">
                        <button 
                            class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                            onclick="openEditModal('U001', 'Internal System', 'PRJ001')"
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
        <h3 class="text-xl font-semibold mb-4">Edit Profile</h3>
        <form>
            <input type="hidden" id="modalUserId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Project</label>
                <input type="text" id="modalProject" class="w-full border rounded-md px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Project ID</label>
                <input type="text" id="modalProjectId" class="w-full border rounded-md px-3 py-2">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="button" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, project, projectId) {
        document.getElementById('modalUserId').value = id;
        document.getElementById('modalProject').value = project;
        document.getElementById('modalProjectId').value = projectId;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
