<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100 min-h-screen">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        @include('layouts.header')

        <!-- Content Slot -->
        <main class="p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')

    </div>
</body>
</html>
