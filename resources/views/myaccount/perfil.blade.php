@extends('layouts.app')

@section('content')
    <!-- Contenedor principal del perfil -->
    <div class="max-w-4xl mx-auto p-6 sm:p-8 bg-white shadow-xl rounded-lg">

        <!-- Título del perfil -->
        <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 mb-6 sm:mb-8">Perfil de {{ $user->name }}</h1>

        <!-- Mensaje de éxito (si existe) -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Contenedor para la foto de perfil y la información del usuario -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-center">

            <!-- Foto de perfil -->
            <div class="text-center sm:text-left">
                <!-- Imagen de perfil (si no tiene, muestra una por defecto) -->
                <img src="{{ $user->profile_picture ?? asset('images/default-profile.png') }}" alt="Foto de perfil"
                    class="w-32 h-32 sm:w-40 sm:h-40 rounded-full mx-auto sm:mx-0 shadow-lg">

                <!-- Formulario para actualizar la foto de perfil -->
                <form action="{{ route('perfil.actualizarFoto') }}" method="POST" enctype="multipart/form-data"
                    class="mt-4 flex flex-col items-center sm:items-start">
                    @csrf
                    <!-- Campo para seleccionar una nueva imagen -->
                    <input type="file" name="profile_picture" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-900 file:text-white hover:file:bg-gray-700">
                    <!-- Botón para subir la nueva imagen -->
                    <button type="submit"
                        class="mt-2 bg-gray-900 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">Actualizar
                        Foto</button>
                </form>
            </div>

            <!-- Información del usuario -->
            <div
                class="p-6 sm:p-8 bg-gradient-to-r from-gray-900 to-gray-700 rounded-lg shadow-lg text-white transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-2xl sm:text-3xl font-semibold mb-4">Información del Usuario</h2>
                <div class="space-y-4">
                    <!-- Email del usuario -->
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-lg w-full sm:w-auto"><strong>Email:</strong></p>
                        <p class="text-lg font-medium w-full sm:w-auto">{{ $user->email }}</p>
                    </div>
                    <!-- Fecha de registro -->
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-lg w-full sm:w-auto"><strong>Miembro desde:</strong></p>
                        <p class="text-lg font-medium w-full sm:w-auto">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                    <!-- Última actividad (si está disponible) -->
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-lg w-full sm:w-auto"><strong>Última actividad:</strong></p>
                        <p class="text-lg font-medium w-full sm:w-auto">
                            {{ $user->last_login ? $user->last_login->diffForHumans() : 'No disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de saldo y añadir fondos -->
        <div class="mt-6 sm:mt-8 space-y-6 sm:space-y-8">

            <!-- Tarjeta de saldo disponible -->
            <div
                class="relative p-6 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-xl shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <!-- Icono de tarjeta -->
                <div class="absolute top-4 right-6 text-xl">💳</div>
                <h2 class="text-xl sm:text-2xl font-semibold">Saldo Disponible</h2>
                <!-- Muestra el saldo disponible -->
                <p class="text-3xl sm:text-4xl font-bold mt-2">{{ number_format($user->balance, 2) }}€</p>
                <!-- Información de la tarjeta (por seguridad solo se muestra parcialmente) -->
                <p class="mt-2 text-sm text-gray-300">Número de tarjeta: **** **** **** 1234</p>
            </div>

            <!-- Sección para añadir fondos -->
            <div
                class="p-6 sm:p-8 bg-gradient-to-r from-gray-900 to-gray-700 rounded-lg shadow-lg text-white transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <h2 class="text-2xl sm:text-3xl font-semibold mb-6">Añadir Fondos</h2>
                <!-- Formulario para añadir fondos al saldo -->
                <form action="{{ route('perfil.anadirFondos') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <!-- Campo para ingresar la cantidad a añadir -->
                        <label for="saldo" class="block text-white text-lg font-medium">Cantidad a añadir</label>
                        <div class="relative mt-2">
                            <!-- Símbolo del euro antes del campo de número -->
                            <span class="absolute inset-y-0 left-3 flex items-center text-white text-lg">€</span>
                            <input type="number" id="saldo" name="saldo" min="1" required
                                class="w-full pl-10 pr-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-300 bg-white text-gray-900">
                        </div>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-3 text-lg rounded-lg hover:bg-gray-700 transition duration-300 flex items-center justify-center">
                        <span class="mr-2">➕</span> Añadir Fondos
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
