<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin-@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->

    @yield('style')
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
       @include('adminV1.layout.partial.sidebar')
       
       <!-- Main Content -->
       <div class="flex-1 flex flex-col overflow-hidden">
           <!-- Top Navigation -->
           @include('adminV1.layout.partial.topheader')
            

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>


    @livewireScripts
@include('adminV1.layout.partial.footer')
</body>
</html>