<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login to Your Account</h2>

        <form method="POST" action="#">
            {{-- CSRF Token (optional if using backend) --}}
            {{-- @csrf --}}

            <!-- User ID -->
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1" for="user_id">User ID</label>
                <input type="text" id="user_id" name="user_id" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-1" for="password">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition">
                    Login
                </button>
            </div>
        </form>
    </div>

</body>
</html>
