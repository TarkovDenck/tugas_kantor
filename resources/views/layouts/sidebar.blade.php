<aside class="w-64 bg-indigo-800 text-white flex-shrink-0">
    <div class="p-6 text-center font-bold text-2xl border-b border-indigo-700">
        MyDashboard
    </div>
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Dashboard</a>
        <a href="{{ route('request') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Request</a>
        <a href="{{ route('request.edit.view') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Edit Request</a>
        <a href="{{ route('request.history') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">History Request</a>
        <a href="{{ route('changepassword') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Change Password</a>
        

        
        @if(Session::get('role') === 'admin')
            <a href="{{ route('profileacctuser') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Manage User Profile</a>
            <a href="{{ route('user.management') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Users Management</a>
            <a href="{{ route('project.management') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Project Management</a>
            <a href="{{ route('admindashboard') }}" class="block px-4 py-2 rounded hover:bg-indigo-700">Admin</a>
        @endif
    </nav>
    <div class="p-4 border-t border-indigo-700"></div>
</aside>
