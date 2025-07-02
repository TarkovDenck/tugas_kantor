<header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>

    <div class="flex items-center gap-4 text-sm text-gray-600">
        <div>
            <span class="font-medium">User ID:</span>
            <a href="{{ route('user.profile') }}" class="text-blue-600 hover:underline">
                {{ session('user_id') ?? 'Guest' }}
            </a> |
            
            <span class="font-medium">Role:</span> {{ session('role') ?? '-' }}
        </div>

        <!-- Tombol Logout -->
        <form method="POST" action="{{ route('logoutuser') }}">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                Logout
            </button>
        </form>
    </div>
</header>
