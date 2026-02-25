<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'soBooking' }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-gray-50 dark:bg-[#0b1a36] font-inter text-gray-800 dark:text-gray-200 antialiased">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav class="bg-[#0D1F3F] text-white shadow-lg sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <a href="{{ route('guest.apartments') }}" class="text-xl font-bold tracking-wider text-[#D4AF37] hover:text-[#b39025] transition-colors">SOBOOKING</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm hover:text-[#D4AF37] transition-colors">Панель</a>
                                    <a href="{{ route('admin.apartments') }}" class="text-sm hover:text-[#D4AF37] transition-colors">Номери</a>
                                    <a href="{{ route('admin.guests') }}" class="text-sm hover:text-[#D4AF37] transition-colors">Гості</a>
                                    <a href="{{ route('admin.checkin') }}" class="text-sm hover:text-[#D4AF37] transition-colors">Заселення</a>
                                    <a href="{{ route('admin.checkout') }}" class="text-sm hover:text-[#D4AF37] transition-colors">Виїзд</a>
                                @endif
                                <span class="text-sm opacity-80 pl-4 border-l border-white/20">Вітаємо, {{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm hover:text-[#D4AF37] transition-colors">Вийти</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm hover:text-[#D4AF37] transition-colors">Увійти</a>
                                <a href="{{ route('register') }}" class="text-sm bg-[#D4AF37] text-[#0D1F3F] px-4 py-2 rounded-lg font-bold hover:bg-[#b39025] transition-colors">Реєстрація</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-grow container mx-auto px-4 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-[#0D1F3F] text-white py-6 mt-auto">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <p class="text-sm opacity-60">&copy; {{ date('Y') }} soBooking. Преміальне проживання.</p>
                </div>
            </footer>
        </div>
        @livewireScripts
    </body>
</html>
