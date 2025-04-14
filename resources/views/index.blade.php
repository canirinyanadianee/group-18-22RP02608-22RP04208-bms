<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Management System</title>
    <!-- Include Tailwind CSS (since it appears to be used in other blade components) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="text-center">
            <!-- Logo -->
            <div class="mb-8">
                <x-application-logo class="w-20 h-20 mx-auto" />
            </div>
            
            <!-- Welcome Text -->
            <h1 class="text-4xl font-bold text-gray-900 mb-8">
                Welcome to Blood Management System (BMS)
            </h1>

            <!-- Links Container -->
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300">
                    Register
                </a>
            </div>
        </div>
    </div>
</body>
</html>
