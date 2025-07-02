<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Neowear')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body class="font-sans bg-gray-100 relative min-h-screen flex flex-col">
    <!-- Overlay, usado para oscurecer el fondo cuando se abre la barra lateral -->
    <div id="overlay"
        class="fixed inset-0 bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300 z-40">
    </div>

    <!-- Sidebar (menú lateral) que contiene los enlaces de navegación -->
    <div id="sidebar"
        class="fixed top-0 left-0 h-full w-96 bg-gray-200 text-black transform -translate-x-full transition-transform duration-500 ease-in-out z-50 shadow-lg p-6 flex flex-col">
        <!-- Título del menú -->
        <div class="text-3xl font-bold text-center mb-10">Menú</div>
        <ul class="space-y-8 text-center flex-grow">
            <!-- Enlaces de navegación para las distintas páginas -->
            <li><a href="{{ route('home.index') }}"
                    class="block text-xl font-medium py-2 transition-all duration-300 hover:text-gray-600 hover:scale-105">Home</a>
            </li>
            <li><a href="{{ route('product.index') }}"
                    class="block text-xl font-medium py-2 transition-all duration-300 hover:text-gray-600 hover:scale-105">Productos</a>
            </li>
            <li><a href="{{ route('cart.index') }}"
                    class="block text-xl font-medium py-2 transition-all duration-300 hover:text-gray-600 hover:scale-105">Carrito</a>
            </li>
            <li><a href="{{ route('home.about') }}"
                    class="block text-xl font-medium py-2 transition-all duration-300 hover:text-gray-600 hover:scale-105">Sobre
                    nosotros</a></li>
            <!-- Solo se muestra si el usuario está autenticado -->
            @guest
            @else
                <li><a href="{{ route('myaccount.orders') }}"
                        class="block text-xl font-medium py-2 transition-all duration-300 hover:text-gray-600 hover:scale-105">Mis
                        pedidos</a></li>
            @endguest
        </ul>

        <!-- Sección de cierre de sesión si el usuario está autenticado -->
        @auth
            <div class="mt-auto text-center border-t border-gray-400 pt-6">
                <form id="logout" action="{{ route('logout') }}" method="POST">
                    @csrf
                    @if (Auth::user() && Auth::user()->getRole() == 'admin')
                        <a href="{{ route('admin.home.index') }}"
                            class="block text-xl font-medium py-2 transition-all duration-300 hover:text-gray-600 hover:scale-105">
                            Admin Panel
                        </a>
                    @endif
                    <a role="button"
                        class="block text-lg font-medium py-2 transition-all duration-300 hover:text-red-500 cursor-pointer"
                        onclick="document.getElementById('logout').submit();">Cerrar sesión</a>
                </form>
            </div>
        @endauth

        <!-- Sección de inicio de sesión y registro si el usuario no está autenticado -->
        @guest
            <div class="text-3xl font-bold text-center mb-10 border-t border-gray-400">
                <a href="{{ route('login') }}"
                    class="block text-lg font-medium py-2 transition-all duration-300 hover:text-red-500 cursor-pointer">Iniciar
                    sesión</a>
                <a href="{{ route('register') }}"
                    class="block text-lg font-medium py-2 transition-all duration-300 hover:text-red-500 cursor-pointer">Registrarse</a>
            </div>
        @endguest
    </div>

    <!-- Navbar (barra de navegación superior) -->
    <nav class="bg-[#000] text-white p-4 flex justify-between items-center z-10 shadow-md relative">
        <!-- Botón para mostrar/ocultar la sidebar -->
        <button onclick="toggleSidebar()"
            class="text-white text-2xl p-2 rounded-lg transition-all duration-300 ease-in-out
            hover:bg-white/20 backdrop-blur-md flex items-center space-x-2 z-20">
            <span class="text-4xl">&#9776;</span> <!-- Icono de menú hamburguesa más grande -->
            <span class="text-xl hidden sm:inline">Menú</span>
            <!-- Texto "Menú" solo en pantallas medianas o más grandes -->
        </button>

        <!-- Título centrado en la barra de navegación -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
            <a href="{{ route('home.index') }}" class="text-2xl font-bold cursor-pointer">NeoWear</a>
        </div>

        <!-- Enlace al perfil solo visible cuando el usuario está autenticado -->
        @auth
            <div class="flex items-center space-x-4">
                <!-- Imagen de perfil solo visible en pantallas pequeñas -->
                <a href="{{ route('perfil') }}" class="sm:hidden">
                    <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('img/default-photo.png') }}"
                        alt="Perfil" class="w-8 h-8 rounded-full border border-white">
                </a>
                <!-- Perfil con nombre solo visible en pantallas grandes -->
                <div class="hidden sm:flex items-center space-x-2">
                    <a href="{{ route('perfil') }}"
                        class="text-xl font-medium text-white hover:text-gray-400 transition-all duration-300 flex items-center space-x-2">
                        <span>Perfil</span>
                        <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('img/default-photo.png') }}"
                            alt="Perfil" class="w-8 h-8 rounded-full border border-white">
                    </a>
                </div>
            </div>
        @endauth
    </nav>

    <!-- Sección hero con un subtítulo -->
    <header class="bg-[#1f1f1f] text-white text-center py-4 shadow-md">
        <div class="container mx-auto">
            <h2>@yield('subtitle', 'Para quienes marcan el ritmo')</h2>
        </div>
    </header>

    <!-- Contenido de la página -->
    <div id="content" class="container mx-auto my-4 transition-all duration-300 ease-in-out mb-0 py-32">
        @yield('content')
    </div>

    <!-- Pie de página -->
    <footer class="bg-[#1f1f1f] text-white text-center py-8 mt-auto">
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Enlaces de navegación -->
            <div class="flex flex-col">
                <h3 class="text-xl font-bold mb-4">Navegación</h3>
                <ul>
                    <li><a href="{{ route('home.index') }}" class="text-lg py-2 hover:text-gray-400">Inicio</a></li>
                    <li><a href="{{ route('product.index') }}" class="text-lg py-2 hover:text-gray-400">Productos</a>
                    </li>
                    <li><a href="{{ route('cart.index') }}" class="text-lg py-2 hover:text-gray-400">Carrito</a></li>
                    <li><a href="{{ route('home.about') }}" class="text-lg py-2 hover:text-gray-400">Sobre nosotros</a>
                    </li>
                    <li><a href="{{ route('myaccount.orders') }}" class="text-lg py-2 hover:text-gray-400">Mis
                            pedidos</a></li>
                </ul>
            </div>

            <!-- Información de contacto -->
            <div class="flex flex-col">
                <h3 class="text-xl font-bold mb-4">Contacto</h3>
                <ul>
                    <li><a href="mailto:contacto@neowear.com"
                            class="text-lg py-2 hover:text-gray-400">contacto@neowear.com</a></li>
                    <li><a href="tel:+1234567890" class="text-lg py-2 hover:text-gray-400">+1 234 567 890</a></li>
                    <li><a href="https://www.instagram.com/neowear" class="text-lg py-2 hover:text-gray-400"
                            target="_blank">Instagram</a></li>
                    <li><a href="https://www.facebook.com/neowear" class="text-lg py-2 hover:text-gray-400"
                            target="_blank">Facebook</a></li>
                    <li><a href="https://www.twitter.com/neowear" class="text-lg py-2 hover:text-gray-400"
                            target="_blank">Twitter</a></li>
                </ul>
            </div>

            <!-- Información adicional -->
            <div class="flex flex-col">
                <h3 class="text-xl font-bold mb-4">Información</h3>
                <ul>
                    <li><a href="https://es.wikipedia.org/wiki/T%C3%A9rminos_y_condiciones_de_uso"
                            class="text-lg py-2 hover:text-gray-400">Términos y condiciones</a></li>
                    <li><a href="https://es.wikipedia.org/wiki/Pol%C3%ADtica_de_privacidad"
                            class="text-lg py-2 hover:text-gray-400">Política de privacidad</a></li>
                    <li><a href="https://www.correos.es/es/es/particulares"
                            class="text-lg py-2 hover:text-gray-400">Envíos y devoluciones</a></li>
                </ul>
            </div>

            <!-- Derechos de autor -->
            <div class="flex flex-col justify-center items-center col-span-1 sm:col-span-2 lg:col-span-4">
                <div class="border-t border-gray-600 pt-6 text-center">
                    <small>
                        Copyright &copy; 2025 <a href="{{ route('home.index') }}"
                            class="text-reset font-bold">NeoWear</a> | Todos los derechos reservados
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script para manejar el toggle del menú lateral -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            const body = document.body;

            const isOpen = !sidebar.classList.contains("-translate-x-full");

            if (isOpen) {
                closeSidebar();
            } else {
                sidebar.classList.remove("-translate-x-full");
                overlay.classList.remove("opacity-0", "pointer-events-none");
                body.classList.add("overflow-hidden");
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            const body = document.body;

            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("opacity-0", "pointer-events-none");
            body.classList.remove("overflow-hidden");
        }

        // Cerrar la sidebar solo si el clic es en el overlay y fuera de la sidebar
        document.getElementById("overlay").addEventListener("click", function(e) {
            const sidebar = document.getElementById("sidebar");

            // Verifica si el clic fue fuera de la sidebar (en el overlay)
            if (!sidebar.contains(e.target)) {
                closeSidebar();
            }
        });
    </script>

    <!-- Script para importar Swiper -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>

</html>
