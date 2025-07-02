@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Request</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <!-- Filter Tanggal -->
    <form method="GET" action="{{ route('request.edit.view') }}" class="flex items-center gap-4 mb-6 flex-wrap">
        <div>
            <label class="text-sm">From</label>
            <input type="date" name="from" value="{{ request('from') }}" class="border px-2 py-1 rounded-md">
        </div>
        <div>
            <label class="text-sm">To</label>
            <input type="date" name="to" value="{{ request('to') }}" class="border px-2 py-1 rounded-md">
        </div>

        @if (session('role') === 'admin')
        <div>
            <label class="text-sm">Filter User</label>
            <select name="filter_user" class="border px-2 py-1 rounded-md">
                <option value="">All Users</option>
                @foreach($allUsers as $user)
                    <option value="{{ $user }}" {{ request('filter_user') == $user ? 'selected' : '' }}>{{ $user }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700">Filter</button>
        </div>
    </form>


    <div class="overflow-x-auto mt-6">
        <table class="min-w-full border border-gray-300 text-sm rounded-md bg-white">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Request ID</th>
                    <th class="px-4 py-2 border">User ID</th>
                    <th class="px-4 py-2 border">Request Type</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Hours</th>
                    <th class="px-4 py-2 border">Note</th>
                    <th class="px-4 py-2 border">Created At</th>
                    <th class="px-4 py-2 border">Updated At</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $id => $request)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration + (($requests->currentPage() - 1) * $requests->perPage()) }}</td>
                        <td class="border px-4 py-2">{{ $id }}</td>
                        <td class="border px-4 py-2">{{ $request['user_id'] }}</td>
                        <td class="border px-4 py-2">{{ $request['request_type'] }}</td>
                        <td class="border px-4 py-2">{{ $request['quantity'] }}</td>
                        <td class="border px-4 py-2">{{ $request['hours'] }}</td>
                        <td class="border px-4 py-2">{{ $request['note'] }}</td>
                        <td class="border px-4 py-2">{{ $request['created_at'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $request['updated_at'] ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <button 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs"
                                    onclick="openEditModal('{{ $id }}', '{{ $request['user_id'] }}', '{{ $request['request_type'] }}', '{{ $request['quantity'] }}', '{{ $request['hours'] }}', '{{ $request['note'] }}')"
                                >
                                    Edit
                                </button>

                                <form method="POST" action="{{ route('request.delete') }}" onsubmit="return confirm('Are you sure you want to delete this request?');">
                                    @csrf
                                    <input type="hidden" name="request_id" value="{{ $id }}">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-500 italic border">No request data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $requests->links() }}
        </div>

        <div class="text-right text-lg font-semibold text-indigo-700 mt-4">
            Total Hours: <span id="total-hours">{{ number_format($totalHours, 1) }}</span>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Edit Request</h3>
        <form id="editRequestForm" method="POST" action="{{ route('request.update') }}">
            @csrf
            <input type="hidden" name="request_id" id="modalRequestId">

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">User ID</label>
                <input type="text" name="user_id" id="modalUserId" class="w-full border rounded-md px-3 py-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Request Type</label>
                <select name="request_type" id="modalRequestType" class="w-full border rounded-md px-3 py-2">
                    <option value="Incident">Incident</option>
                    <option value="Service Request">Service Request</option>
                    <option value="Internal Support">Internal Support</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Quantity</label>
                <input type="number" name="quantity" id="modalQuantity" class="w-full border rounded-md px-3 py-2" min="1">
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Hours</label>
                <input type="number" step="0.1" name="hours" id="modalHours" class="w-full border rounded-md px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Note</label>
                <input type="text" name="note" id="modalNote" class="w-full border rounded-md px-3 py-2">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, userId, requestType, quantity, hours, note) {
        document.getElementById('modalRequestId').value = id;
        document.getElementById('modalUserId').value = userId;
        document.getElementById('modalRequestType').value = requestType;
        document.getElementById('modalQuantity').value = quantity;
        document.getElementById('modalHours').value = hours;
        document.getElementById('modalNote').value = note;

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
