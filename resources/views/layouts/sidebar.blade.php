<aside class="w-64 bg-indigo-800 text-white flex-shrink-0">
    <div class="p-6 text-center font-bold text-2xl border-b border-indigo-700">
        MyDashboard
    </div>
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Dashboard</a>
        <a href="{{ route('request') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Request</a>
        <a href="{{ route('history') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">History Request</a>
        <a href="{{ route('changepassword') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Change Password</a>
        <a href="{{ route('profileacctuser') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Manage User Profile</a>
        <a href="{{ route('users') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Users</a>
        <a href="{{ route('admindashboard') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Admin</a>
    </nav>
    <div class="p-4 border-t border-indigo-700">
        <form method="POST" action="">
            @csrf
            <button type="submit" class="w-full px-4 py-2 bg-red-600 rounded hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>
</aside>
