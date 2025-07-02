@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Información del producto -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Nombre del producto -->
            <h1 class="text-2xl font-bold">{{ $viewData['product']->getName() }}</h1>
            <!-- Descripción del producto -->
            <p class="text-gray-700 mt-2">{{ $viewData['product']->getDescription() }}</p>
            <!-- Precio del producto -->
            <p class="text-xl font-semibold text-gray-900 mt-4">Precio: ${{ $viewData['product']->getPrice() }}</p>
        </div>

        <!-- Sección de Reviews -->
        <div class="mt-8 bg-white shadow-md rounded-lg p-6">
            <!-- Título de la sección de reseñas -->
            <h2 class="text-xl font-semibold mb-4">Reseñas del Producto</h2>

            <!-- Verificación de si hay reseñas -->
            @if ($viewData['reviews']->isEmpty())
                <!-- Si no hay reseñas, mostrar mensaje de invitación -->
                <p class="text-gray-600">Aún no hay reseñas. ¡Sé el primero en dejar una!</p>
            @else
                <!-- Si hay reseñas, recorrerlas -->
                @foreach ($viewData['reviews'] as $review)
                    <div class="border-b border-gray-200 py-4">
                        <!-- Mostrar la calificación -->
                        <p class="text-yellow-500">
                            ⭐ {{ $review->rating }}/5
                        </p>
                        <!-- Mostrar el comentario -->
                        <p class="text-gray-800 mt-1">{{ $review->comment }}</p>
                        <!-- Mostrar la fecha de publicación -->
                        <p class="text-sm text-gray-500">Publicado el {{ $review->created_at->format('d/m/Y') }}</p>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Formulario para agregar una Review -->
        <div class="mt-8 bg-white shadow-md rounded-lg p-6">
            <!-- Título del formulario -->
            <h2 class="text-xl font-semibold mb-4">Escribe una Reseña</h2>
            <!-- Formulario para enviar reseña -->
            <form action="{{ route('reviews.store', $viewData['product']->id) }}" method="POST">
                @csrf
                <!-- Campo de puntuación (1-5) -->
                <label for="rating" class="block text-sm font-medium text-gray-700">Puntuación (1-5)</label>
                <input type="number" name="rating" min="1" max="5" class="w-full border rounded-lg p-2 mt-1"
                    required>

                <!-- Campo de comentario -->
                <label for="comment" class="block text-sm font-medium text-gray-700 mt-4">Comentario</label>
                <textarea name="comment" class="w-full border rounded-lg p-2 mt-1" required></textarea>

                <!-- Botón para enviar la reseña -->
                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Enviar Reseña
                </button>
            </form>
        </div>
    </div>
@endsection
