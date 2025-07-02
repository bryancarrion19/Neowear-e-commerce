<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" />
    <title>@yield('title', 'Admin - Online Store')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/faviconA.png') }}">
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <div class="flex flex-1 relative">
        <!-- Sidebar -->
        <div id="sidebar"
            class="w-64 bg-gray-900 text-white p-6 flex flex-col fixed inset-0 lg:static lg:w-64 lg:block transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
            <a href="{{ route('admin.home.index') }}"
                class="text-white text-xl sm:text-2xl font-bold mb-6 block text-center">
                Admin Panel
            </a>
            <ul class="space-y-4 text-xs sm:text-sm flex-1">
                <li><a href="{{ route('admin.home.index') }}" class="block text-gray-300 hover:text-white transition">🏠
                        Home</a></li>
                <li><a href="{{ route('admin.product.index') }}"
                        class="block text-gray-300 hover:text-white transition">📦 Products</a></li>
                <li><a href="{{ route('admin.pedidos.index') }}"
                        class="block text-gray-300 hover:text-white transition">📜 Pedidos</a></li>
                <li>
                    <a href="{{ route('admin.backup.index') }}"
                        class="block text-gray-300 hover:text-white transition">💾 Copias de Seguridad</a>
                </li>
            </ul>

            <!-- Moved "Volver a inicio" button to the bottom -->
            <a href="{{ route('home.index') }}"
                class="fixed absolute bottom-0 px-4 py-2 bg-gray-700 text-center text-white rounded-lg hover:bg-gray-600 transition mt-auto">
                🔙 Volver a inicio
            </a>
        </div>
        <!-- Sidebar -->

        <!-- Overlay (for mobile view) -->
        <div id="overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden"></div>

        <!-- Content Area -->
        <div class="flex-1 bg-gray-50">
            <!-- Navbar with Hamburger Icon -->
            <nav class="bg-white p-3 sm:p-4 shadow-md flex justify-between items-center border-b border-gray-200">
                <div class="lg:hidden">
                    <!-- Hamburger Menu Icon -->
                    <button id="menu-toggle" class="text-gray-700 text-xl">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <span class="text-sm sm:text-lg font-semibold text-gray-700">Admin Dashboard</span>
                <div class="flex items-center space-x-3">
                    <span class="text-xs sm:text-sm text-gray-700 font-medium">Admin</span>
                    <!-- Imagen del perfil -->
                    <img class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gray-300"
                        src="{{ asset('/img/undraw_profile.svg') }}" alt="Profile">
                </div>
            </nav>

            <div class="p-4 sm:p-6 bg-white shadow-md rounded-lg mx-4 sm:mx-6 mt-4 sm:mt-6">
                @yield('content')
            </div>
        </div>
        <!-- Content Area -->
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-center text-white py-4 sm:py-6 mt-auto">
        <div class="container mx-auto">
            <!-- Grid para las columnas del footer -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Columna 1 -->
                <div class="flex justify-center items-center">
                    <small class="text-xs sm:text-sm">&copy; 2025 - <a class="text-blue-400 hover:text-blue-600"
                            href="https://twitter.com/danielgarax" target="_blank">Bryan Carrion</a></small>
                </div>

                <!-- Columna 2 -->
                <div class="flex justify-center items-center">
                    <div class="text-xs sm:text-sm text-gray-400">
                        <a href="#" class="hover:text-white">Privacy Policy</a> |
                        <a href="#" class="hover:text-white">Terms of Service</a>
                    </div>
                </div>

                <!-- Columna 3 -->
                <div class="flex justify-center items-center">
                    <p class="mt-2 text-xs sm:text-sm text-gray-400">Admin Panel for NeoWear | Version 1.0</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // JavaScript para abrir/cerrar el sidebar en pantallas pequeñas
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Cerrar el sidebar al hacer clic en el overlay
        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>

</html>
