<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Job Portal')</title>

    <!-- TailwindCSS CDN for simplicity -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Left: Site Title -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600">JobPortal</a>

            <!-- Right: Navigation + Create Job button -->
            <div class="flex items-center space-x-4">
                {{-- @auth --}}
                    <!-- Create Job Button -->
                    <a href="{{ route('job_postings.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Create Job
                    </a>
                {{-- @endauth --}}

                {{-- <nav class="space-x-4">
                    <a href="{{ route('job_postings.index') }}" class="hover:text-blue-600">Jobs</a>

                    @guest
                        <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="hover:text-blue-600">Register</a>
                    @else
                        <span>Hi, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-blue-600">Logout</button>
                        </form>
                    @endguest
                </nav> --}}
            </div>
        </div>
    </header>


    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-6 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-auto">
        <div class="container mx-auto px-6 py-4 text-center text-gray-600">
            &copy; {{ date('Y') }} JobPortal. All rights reserved.
        </div>
    </footer>

</body>
</html>
