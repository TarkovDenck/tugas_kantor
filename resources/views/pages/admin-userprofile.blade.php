@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Manage User Profiles</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm rounded-md bg-white">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">User ID</th>
                    <th class="px-4 py-2 border">Project</th>
                    <th class="px-4 py-2 border">Project ID</th>
                    <th class="px-4 py-2 border">Created</th>
                    <th class="px-4 py-2 border">Updated</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($profiles as $profile)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $profile['user_id'] }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $profile['project'] }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $profile['project_id'] }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $profile['created_at'] }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $profile['updated_at'] }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-center">
                            <button 
                                onclick="openEditModal('{{ $profile['user_id'] }}', '{{ $profile['project'] }}')" 
                                class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-xs"
                            >
                                Edit
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 italic border">No profile data found.</td>
                    </tr>
                @endforelse
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
