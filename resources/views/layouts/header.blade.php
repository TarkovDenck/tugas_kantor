<header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
    <div class="text-sm text-gray-600">
        <span>User ID:</span> <strong>{{ Auth::user()->id ?? 'Guest' }}</strong>
    </div>
</header>
