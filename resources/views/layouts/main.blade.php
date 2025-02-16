<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        /* body {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #333;
            color: white;
            padding: 15px;
            height: 100vh;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }

        .sidebar a.active {
            background: #555;
        }

         */
    </style>
    <link rel="icon" href={{ asset('assets/images/takumi_logo.png') }}>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/app.css') }}">
</head>

<body>
    <nav class="navbar">
        <img src={{ asset('assets/images/takumi_logo.png') }} alt="Takumi">
        <div id="clock"></div>
    </nav>
    <main>
        <div class="sidebar">
            <ul>
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                    <li><i class="uil uil-estate"></i>Dashboard</li>
                </a>
                <a href="{{ url('/absensi') }}" class="{{ request()->is('absensi') ? 'active' : '' }}">
                    <li><i class="uil uil-clock"></i>Absensi</li>
                </a>
            </ul>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </main>
    <script>
        //Dashboard
        document.addEventListener("DOMContentLoaded", function() {
            setInterval(updateClock, 1000);
            updateClock();
        })

        //ganti tema
        // Fungsi untuk toggle tema antara dark mode dan light mode
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');

            // Simpan preferensi mode ke local storage
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }

        // Periksa localStorage untuk menerapkan mode yang disimpan
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
        }

        function openModal(id) {
            document.getElementById(id).classList.remove("hidden");
        }

        function closeModal(id) {
            document.getElementById(id).classList.add("hidden");
        }
    </script>
</body>

</html>