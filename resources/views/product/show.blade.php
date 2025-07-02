@extends('layouts.app')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')
    <div
        class="card mb-6 bg-white shadow-md rounded-lg overflow-hidden max-w-xs sm:max-w-md md:max-w-lg lg:max-w-3xl xl:max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row">
            <!-- Imagen del producto -->
            <div class="w-full md:w-1/2 lg:w-1/3">
                <img src="{{ Str::startsWith($viewData['product']->getImage(), ['http://', 'https://'])
                    ? $viewData['product']->getImage()
                    : asset('/img/' . $viewData['product']->getImage()) }}"
                    class="w-full h-full object-cover">
            </div>

            <!-- Detalles del producto -->
            <div class="w-full md:w-1/2 lg:w-2/3 p-4 sm:p-6 lg:p-8">
                <h5 class="text-3xl font-bold text-gray-900">
                    {{ $viewData['product'] ? $viewData['product']->getName() : 'Nombre no disponible' }}
                    (${{ $viewData['product'] ? $viewData['product']->getPrice() : '0.00' }})
                </h5>

                <p class="mt-4 text-gray-700">
                    {{ $viewData['product'] ? $viewData['product']->getDescription() : 'Descripción no disponible' }}
                </p>

                @if ($viewData['product'])
                    <form method="POST" action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}"
                        class="mt-6">
                        @csrf
                        <div class="flex items-center gap-4">
                            <div class="flex items-center bg-gray-100 rounded-lg p-2">
                                <span class="text-gray-700 mr-2">Talla</span>
                                <select name="size" class="p-2 border border-gray-300 rounded-lg">
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>
                            <div class="flex items-center bg-gray-100 rounded-lg p-2">
                                <span class="text-gray-700 mr-2">Cantidad</span>
                                <input type="number" min="1" max="10"
                                    class="w-16 p-2 border border-gray-300 rounded-lg" name="quantity" value="1">
                            </div>
                        </div>
                        <button class="bg-blue-500 text-white px-8 py-2 rounded-lg hover:bg-blue-600 transition-colors mt-4"
                            type="submit">
                            Agregar al carrito
                        </button>
                    </form>
                @else
                    <p class="text-red-500">Producto no disponible.</p>
                @endif

                <!-- Botón para ir a la sección de reseñas -->
                <a href="{{ route('reviews.show', $viewData['product']['id'] ?? $viewData['product']->getId()) }}"
                    class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Añadir reseña
                </a>
            </div>
        </div>

        <!-- Sección para compartir en redes sociales -->
        <div class="border-t border-gray-200 mt-6 p-4 sm:p-6 lg:p-8">
            <h3 class="text-lg font-semibold mb-4">Compartir en redes sociales</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($viewData['product']->getName() . ' - ' . url()->current()) }}"
                    target="_blank"
                    class="px-4 py-2 bg-green-500 text-white rounded flex items-center justify-center gap-2 transform transition-transform hover:scale-110">
                    📱 WhatsApp
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                    class="px-4 py-2 bg-blue-600 text-white rounded flex items-center justify-center gap-2 transform transition-transform hover:scale-110">
                    📘 Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($viewData['product']->getName()) }}&url={{ urlencode(url()->current()) }}"
                    target="_blank"
                    class="px-4 py-2 bg-black text-white rounded flex items-center justify-center gap-2 transform transition-transform hover:scale-110">
                    🐦 X (Twitter)
                </a>
                <a href="#"
                    class="px-4 py-2 bg-pink-600 text-white rounded flex items-center justify-center gap-2 transform transition-transform hover:scale-110">
                    📸 Instagram
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de Reseñas del Producto -->
    <div id="reviews-section"
        class="mt-8 bg-white shadow-md rounded-lg p-4 sm:p-6 lg:p-8 max-w-xs sm:max-w-md md:max-w-lg mx-auto">
        <h2 class="text-xl font-semibold mb-4">Reseñas del Producto</h2>

        <!-- Verificación de si hay reseñas -->
        @if ($viewData['reviews']->isEmpty())
            <p class="text-gray-600">Aún no hay reseñas. ¡Sé el primero en dejar una!</p>
        @else
            @foreach ($viewData['reviews'] as $review)
                <div class="border-b border-gray-200 py-4">
                    <p class="text-yellow-500">⭐ {{ $review->rating }}/5</p>
                    <p class="text-gray-800 mt-1">{{ $review->comment }}</p>
                    <p class="text-sm text-gray-500">Publicado el {{ $review->created_at->format('d/m/Y') }}</p>
                </div>
            @endforeach
        @endif

        <!-- Botón para volver a la sección de productos -->
        <a href="{{ route('product.index') }}"
            class="mt-6 inline-block bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            Volver a la sección de productos
        </a>
    </div>
@endsection
