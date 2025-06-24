@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Manage User Profiles</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">User ID</th>
                    <th class="px-4 py-2 text-left">Project</th>
                    <th class="px-4 py-2 text-left">Project ID</th>
                    <th class="px-4 py-2 text-left">Created</th>
                    <th class="px-4 py-2 text-left">Updated</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profiles as $profile)
                    <tr>
                        <td class="px-4 py-2">{{ $profile['user_id'] }}</td>
                        <td class="px-4 py-2">{{ $profile['project'] }}</td>
                        <td class="px-4 py-2">{{ $profile['project_id'] }}</td>
                        <td class="px-4 py-2">{{ $profile['created_at'] }}</td>
                        <td class="px-4 py-2">{{ $profile['updated_at'] }}</td>
                        <td class="px-4 py-2">
                            <button onclick="openEditModal('{{ $profile['user_id'] }}', '{{ $profile['project'] }}')" 
                                    class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                                Edit
                            </button>
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
        <h3 class="text-xl font-semibold mb-4">Edit Profile</h3>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <input type="hidden" name="user_id" id="editUserId">

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Project Name</label>
                <select name="project" id="editProjectName" onchange="fillProjectId()" class="w-full border rounded-md px-3 py-2">
                    <option value="" disabled selected>Select a project</option>
                    @foreach ($projects as $p)
                        <option value="{{ $p['project_name'] }}">{{ $p['project_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Project ID</label>
                <input type="text" name="project_id" id="editProjectId" readonly class="w-full border rounded-md px-3 py-2 bg-gray-100 text-gray-700">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Data project (Laravel kirim dari PHP ke JS)
    const projectMap = @json(array_column($projects, 'project_id', 'project_name'));

    function openEditModal(userId, projectName) {
        document.getElementById('editUserId').value = userId;
        document.getElementById('editProjectName').value = projectName;
        document.getElementById('editProjectId').value = projectMap[projectName] ?? '';

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function fillProjectId() {
        const projectName = document.getElementById('editProjectName').value;
        document.getElementById('editProjectId').value = projectMap[projectName] ?? '';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
