<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Admin Dashboard - Artin LMS' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 font-sans antialiased text-gray-900">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-900 text-white flex flex-col">
                <div class="h-16 flex items-center justify-center border-b border-gray-800 text-xl font-bold">
                    Artin LMS Admin
                </div>
                <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                    <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">
                        Dashboard
                    </a>
                    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                        Students
                    </a>
                    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                        Courses
                    </a>
                    <a href="/admin/live-classes" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.live-classes') ? 'bg-gray-800' : '' }}">
                        Live Classes
                    </a>
                    <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                        Videos
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                <!-- Topbar -->
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Admin User</span>
                    </div>
                </header>

                <main class="flex-1 bg-gray-50 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
