@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Project Management</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <!-- Form Tambah Project -->
    <form action="{{ route('project.add') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-6">
        @csrf
        <div>
            <label class="block text-sm text-gray-600 mb-1">Project ID</label>
            <input type="text" name="project_id" class="w-full border rounded-md px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Project Name</label>
            <input type="text" name="project_name" class="w-full border rounded-md px-3 py-2" required>
        </div>
        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Save</button>
        </div>
    </form>

    <!-- Table Project -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Project ID</th>
                    <th class="border px-4 py-2">Project Name</th>
                    <th class="border px-4 py-2">Created At</th>
                    <th class="border px-4 py-2">Updated At</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $project['project_id'] }}</td>
                    <td class="border px-4 py-2">{{ $project['project_name'] }}</td>
                    <td class="border px-4 py-2">{{ $project['created_at'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $project['updated_at'] ?? '-' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <button 
                            onclick="openEditModal('{{ $project['project_id'] }}', '{{ $project['project_name'] }}')" 
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2"
                        >Edit</button>

                        <form action="{{ route('project.delete', $project['project_id']) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this project?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Edit Project</h3>
        <form id="editProjectForm" method="POST">
            @csrf

            <!-- Hidden untuk menyimpan ID lama -->
            <input type="hidden" name="old_project_id" id="oldProjectId">

            <!-- Project ID yang bisa diedit -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Project ID</label>
                <input type="text" name="project_id" id="editProjectId" class="w-full border rounded-md px-3 py-2" required>
            </div>

            <!-- Project Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Project Name</label>
                <input type="text" name="project_name" id="editProjectName" class="w-full border rounded-md px-3 py-2" required>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</div>



<script>
    function openEditModal(id, name) {
        document.getElementById('editProjectId').value = id;
        document.getElementById('editProjectName').value = name;
        document.getElementById('oldProjectId').value = id;

        const form = document.getElementById('editProjectForm');
        form.action = '/project-edit/' + encodeURIComponent(id); // jika masih pakai route lama

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

</script>
@endsection
