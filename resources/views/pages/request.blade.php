@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Request Page</h2>

    <!-- Area tampil hasil request -->
    <div id="request-list" class="space-y-4 mb-6"></div>

    <!-- Tombol Insert -->
    <div class="mb-6">
        <form id="insertForm" method="POST" action="{{ route('request.store') }}">
            @csrf
            <input type="hidden" name="requests" id="hiddenRequests">
            <button type="submit" onclick="prepareSubmission()" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition font-semibold">
                INSERT
            </button>
        </form>
    </div>

    <!-- Form Request -->
    <form id="request-form" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Request Type</label>
                <select id="request-type" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="Incident">Incident</option>
                    <option value="Service Request">Service Request</option>
                    <option value="Internal Support">Internal Support</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Number (1 - 100)</label>
                <select id="select-number" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @for ($i = 1; $i <= 100; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Hours</label>
                <input type="number" step="0.1" id="hours" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. 3.5">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Note</label>
                <input type="text" id="note" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Write a note...">
            </div>
        </div>

        <div class="md:col-span-2">
            <button type="button" id="add-update-btn" onclick="submitForm()" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-semibold">
                ADD
            </button>
        </div>
    </form>
</div>

<script>
    let requestData = [];
    let isEditing = false;
    let editIndex = null;

    function renderRequests() {
        const container = document.getElementById('request-list');
        container.innerHTML = '';

        requestData.forEach((data, index) => {
            const row = document.createElement('div');
            row.className = "p-4 border rounded-md shadow-sm bg-gray-100 flex flex-col md:flex-row justify-between md:items-center";

            row.innerHTML = `
                <div class="space-y-1">
                    <p><strong>Type:</strong> ${data.requestType}</p>
                    <p><strong>Number:</strong> ${data.number}</p>
                    <p><strong>Hours:</strong> ${data.hours}</p>
                    <p><strong>Note:</strong> ${data.note}</p>
                </div>
                <div class="mt-3 md:mt-0">
                    <button onclick="editRequest(${index})" class="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                        Edit
                    </button>
                </div>
            `;
            container.appendChild(row);
        });
    }

    function submitForm() {
        const requestType = document.getElementById('request-type').value;
        const number = document.getElementById('select-number').value;
        const hours = document.getElementById('hours').value;
        const note = document.getElementById('note').value;

        if (!hours) {
            alert("Jam wajib diisi.");
            return;
        }

        const data = { requestType, number, hours, note };

        if (isEditing && editIndex !== null) {
            requestData[editIndex] = data;
            isEditing = false;
            editIndex = null;
            document.getElementById('add-update-btn').innerText = 'ADD';
        } else {
            requestData.push(data);
        }

        resetForm();
        renderRequests();
    }

    function editRequest(index) {
        const data = requestData[index];

        document.getElementById('request-type').value = data.requestType;
        document.getElementById('select-number').value = data.number;
        document.getElementById('hours').value = data.hours;
        document.getElementById('note').value = data.note;

        isEditing = true;
        editIndex = index;
        document.getElementById('add-update-btn').innerText = 'UPDATE';
    }

    function prepareSubmission() {
        const hiddenInput = document.getElementById('hiddenRequests');
        hiddenInput.value = JSON.stringify(requestData);
    }

    function resetForm() {
        document.getElementById('request-type').value = 'Incident';
        document.getElementById('select-number').value = '1';
        document.getElementById('hours').value = '';
        document.getElementById('note').value = '';
        document.getElementById('add-update-btn').innerText = 'ADD';
    }
</script>
@endsection
