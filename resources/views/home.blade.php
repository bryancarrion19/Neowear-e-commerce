@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Hero Section: Sección principal con el carrusel de imágenes -->
        <header class="relative w-full h-screen">
            <!-- Componente Alpine.js para el carrusel -->
            <div x-data="carousel()" x-init="startAutoSlide()" class="relative w-full h-full">

                <!-- Imagen de fondo dinámica -->
                <img :src="images[currentIndex]" alt="Background"
                    class="absolute inset-0 w-full h-full object-cover rounded-xl transition-opacity duration-500">

                <!-- Overlay oscuro con sombra para mejorar la visibilidad del texto -->
                <div
                    class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-xl shadow-[inset_0_0_20px_10px_rgba(0,0,0,0.6)]">
                    <!-- Texto centrado con efecto hover (zoom) y color al pasar el ratón -->
                    <a href="#"
                        class="text-white text-5xl font-extrabold uppercase text-center tracking-wide transition-transform duration-500 transform hover:scale-110 hover:cursor-pointer hover:text-yellow-400">
                        New Collection
                    </a>
                </div>

                <!-- Flechas de navegación (aparecen en hover) para navegar por las imágenes -->
                <div @mouseover="pauseAutoSlide()" @mouseleave="startAutoSlide()"
                    class="absolute inset-0 flex justify-between items-center px-8 opacity-0 hover:opacity-100 transition-opacity duration-300">
                    <!-- Flecha izquierda: Anterior imagen -->
                    <button @click="prevImage()"
                        class="text-white bg-black bg-opacity-50 p-3 rounded-full hover:bg-opacity-75 transition">
                        &#10094;
                    </button>

                    <!-- Flecha derecha: Siguiente imagen -->
                    <button @click="nextImage()"
                        class="text-white bg-black bg-opacity-50 p-3 rounded-full hover:bg-opacity-75 transition">
                        &#10095;
                    </button>
                </div>
            </div>
        </header>

        <!-- Sección de productos destacados -->
        <section class="py-16 px-8 pb-32">
            <h3 class="text-3xl font-bold text-center mb-8">Más vendido</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Producto 1 -->
                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <img src="{{ asset('img/trendyJacket.jpeg') }}" alt="Product" class="w-full h-[500px] object-cover">
                    <div class="p-4 text-center">
                        <h4 class="text-lg font-semibold">Trendy Jacket</h4>
                        <p class="text-gray-500">$59.99</p>
                    </div>
                </div>
                <!-- Producto 2 -->
                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <img src="{{ asset('img/baggyjeans.jpeg') }}" alt="Product" class="w-full h-[500px] object-cover">
                    <div class="p-4 text-center">
                        <h4 class="text-lg font-semibold">Baggy Jeans</h4>
                        <p class="text-gray-500">$79.99</p>
                    </div>
                </div>
                <!-- Producto 3 -->
                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <img src="{{ asset('img/hoodie.jpeg') }}" alt="Product" class="w-full h-[500px] object-cover">
                    <div class="p-4 text-center">
                        <h4 class="text-lg font-semibold">Casual Hoodie</h4>
                        <p class="text-gray-500">$49.99</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Agregar Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Script del carrusel con auto-slide -->
    <script>
        function carousel() {
            return {
                // Array de imágenes del carrusel
                images: [
                    '{{ asset('img/fotoFondoSI.jpg') }}',
                    '{{ asset('img/fotoFondo.jpg') }}',
                    '{{ asset('img/fotoFondo3.jpg') }}'
                ],
                currentIndex: 0, // Índice de la imagen actual
                interval: null, // Intervalo para el auto-slide

                // Iniciar el auto-slide de imágenes
                startAutoSlide() {
                    this.stopAutoSlide(); // Asegura que no haya intervalos duplicados
                    this.interval = setInterval(() => {
                        this.nextImage(); // Cambiar imagen cada 5 segundos
                    }, 5000);
                },

                // Detener el auto-slide
                stopAutoSlide() {
                    clearInterval(this.interval);
                },

                // Pausar el auto-slide cuando el usuario interactúa
                pauseAutoSlide() {
                    this.stopAutoSlide();
                },

                // Cambiar a la siguiente imagen
                nextImage() {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                },

                // Cambiar a la imagen anterior
                prevImage() {
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                }
            };
        }
    </script>
@endsection
