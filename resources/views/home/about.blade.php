@extends('layouts.app')

@section('title', 'Acerca de Nosotros') <!-- Define el título de la página como "Acerca de Nosotros" -->

@section('content') <!-- Comienza la sección de contenido -->
    <!-- Contenedor principal con un fondo blanco, sombra, y bordes redondeados -->
    <div class="max-w-5xl mx-auto p-8 bg-white shadow-xl rounded-lg space-y-8 -mt-28">

        <!-- Imagen de portada con fondo, altura fija y bordes redondeados -->
        <div class="w-full h-72 bg-cover bg-center rounded-lg" style="background-image: url('{{ asset('img/1.jpg') }}');">
            <!-- Capa oscura sobre la imagen de portada para crear un contraste -->
            <div class="h-full bg-black opacity-40 rounded-lg"></div>
        </div>

        <!-- Contenido principal centrado -->
        <div class="text-center space-y-6">
            <!-- Título principal de la página -->
            <h1 class="text-4xl font-bold text-gray-900">Acerca de Nosotros</h1>

            <!-- Descripción sobre la tienda y su propósito -->
            <div class="text-lg text-gray-600">
                <p>Bienvenido a nuestra tienda. Somos un equipo apasionado por la moda y la sostenibilidad. Nuestro objetivo
                    es ofrecerte productos de alta calidad que se adapten a tus gustos, al tiempo que promovemos el respeto
                    por el medio ambiente.</p>
            </div>

            <!-- Subtítulo para la misión de la tienda -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-8">Nuestra Misión</h2>
            <!-- Descripción de la misión de la tienda -->
            <p class="text-gray-600">Proporcionar moda accesible y de calidad, siempre con un enfoque en la sostenibilidad y
                la ética en la producción.</p>

            <!-- Subtítulo para explicar las razones para elegir la tienda -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-8">¿Por qué elegirnos?</h2>
            <!-- Lista de razones por las que elegir esta tienda, con iconos -->
            <ul class="list-none space-y-3 text-left max-w-lg mx-auto">
                <li class="flex items-center text-gray-600">
                    <!-- Icono para ilustrar cada razón -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800 mr-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Variedad de productos de alta calidad.
                </li>
                <li class="flex items-center text-gray-600">
                    <!-- Icono para ilustrar la razón -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800 mr-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Enfoque en la sostenibilidad.
                </li>
                <li class="flex items-center text-gray-600">
                    <!-- Icono para ilustrar la razón -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800 mr-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Precios accesibles para todos los presupuestos.
                </li>
                <li class="flex items-center text-gray-600">
                    <!-- Icono para ilustrar la razón -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800 mr-3" fill="none"
                        viewBox="http://www.w3.org/2000/svg" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Envíos rápidos y seguros.
                </li>
            </ul>

            <!-- Subtítulo sobre el equipo -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-8">Nuestro Equipo</h2>
            <!-- Descripción del equipo -->
            <p class="text-gray-600">Un equipo diverso y experimentado de diseñadores, tecnólogos y expertos en moda que
                trabajan juntos para ofrecerte lo mejor.</p>
        </div>
    </div>
@endsection
