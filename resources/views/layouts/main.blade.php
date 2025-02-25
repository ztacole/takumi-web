<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href={{ asset('assets/images/takumi_logo.png') }}>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/app.css') }}">
</head>

<body class="h-screen flex flex-col">
    <nav class="navbar">
        <div class="flex items-center gap-4">
            <img src={{ asset('assets/images/takumi_logo.png') }} alt="Takumi">
        </div>
        
        <div id="clock" class="hidden md:block lg:block"></div>
        
        <!-- Menu toggle -->
        <div class="hamburger-menu" onclick="toggleMenu()">
            <i id="menuIcon" class="uil uil-bars"></i>
        </div>

        <!-- Menu mobile -->
        <div id="mobileMenu" class="hidden">
            <div class="mobile-menu-content">
                <ul class="py-2">
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('/dashboard') ? 'active' : '' }}">
                        <li class="px-4 py-2 hover:bg-gray-100"><i class="uil uil-estate"></i>Dashboard</li>
                    </a>
                    <a href="{{ url('/absensi') }}" class="{{ request()->is('absensi') ? 'active' : '' }}">
                        <li class="px-4 py-2 hover:bg-gray-100"><i class="uil uil-clock"></i>Absensi</li>
                    </a>
                </ul>
                <!-- Clock untuk mobile -->
                <div id="mobileClock" class="px-4 py-2 text-center"></div>
            </div>
        </div>
    </nav>

    <main class="flex-1 flex">
        <!-- Sidebar desktop -->
        <div class="sidebar">
            <ul>
                <a href="{{ url('/dashboard') }}" class="{{ request()->is('/dashboard') ? 'active' : '' }}">
                    <li><i class="uil uil-estate"></i>Dashboard</li>
                </a>
                <a href="{{ url('/absensi') }}" class="{{ request()->is('absensi') ? 'active' : '' }}">
                    <li><i class="uil uil-clock"></i>Absensi</li>
                </a>
            </ul>
        </div>
        <div class="content mx-auto flex-1 px-4 py-6">
            @yield('content')
        </div>
    </main>

    <footer class="py-4 text-center text-sm text-black dark:text-white/70">
        <p>&copy; 2025 Takumi. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setInterval(updateClock, 1000);
            updateClock();
        })

        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }

        window.onload = function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        };

        function updateClock() {
            const date = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const now = date.toLocaleDateString('id-ID', options) + ' | ' + date.toLocaleTimeString('id-ID');
            document.getElementById('clock').innerText = now;
            const mobileClock = document.getElementById('mobileClock');
            if (mobileClock) {
                mobileClock.innerText = now;
            }
        }

        function toggleMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            
            mobileMenu.classList.toggle('hidden');
            // Ganti icon saat menu terbuka/tertutup
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.classList.remove('uil-times');
                menuIcon.classList.add('uil-bars');
            } else {
                menuIcon.classList.remove('uil-bars');
                menuIcon.classList.add('uil-times');
            }
        }
    </script>
</body>

</html>