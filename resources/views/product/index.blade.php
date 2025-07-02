@extends('layouts.app')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')
    <!-- Contenedor principal de la página -->
    <div class="min-h-screen bg-gray-50 py-12">

        <!-- Barra de búsqueda y filtros -->
        <div
            class="container mx-auto px-4 mb-8 flex flex-wrap justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <!-- Barra de búsqueda -->
            <div
                class="w-full sm:w-1/3 bg-white p-3 rounded-lg shadow-sm flex items-center space-x-3 border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                <!-- Icono de búsqueda -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <!-- Campo de texto para realizar la búsqueda -->
                <input type="text" id="search" placeholder="Buscar productos..."
                    class="w-full px-4 py-2 border-none rounded-md focus:outline-none focus:ring-0 text-gray-700 placeholder-gray-400">
            </div>

            <!-- Filtros de categoría y precio -->
            <div class="flex flex-wrap gap-4 w-full sm:w-auto justify-between sm:justify-start">
                <!-- Filtro de categoría -->
                <select id="category-filter"
                    class="px-4 py-2 border rounded-lg shadow-sm bg-white text-gray-700 border-gray-200 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-200 w-full sm:w-auto">
                    <option value="">Categoría</option>
                    <option value="1">Pantalones</option>
                    <option value="2">Sudaderas</option>
                    <option value="3">Camisetas</option>
                    <option value="4">Camisas y cazadoras</option>
                    <option value="5">Zapatos</option>
                    <option value="6">Accesorios</option>
                </select>

                <!-- Filtro de rango de precio -->
                <select id="price-filter"
                    class="px-4 py-2 border rounded-lg shadow-sm bg-white text-gray-700 border-gray-200 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-200 w-full sm:w-auto">
                    <option value="">Rango de precio</option>
                    <option value="low">Bajo</option>
                    <option value="medium">Medio</option>
                    <option value="high">Alto</option>
                </select>
            </div>
        </div>

        <!-- Grid de productos -->
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Nuestra Colección</h2>
            <!-- Contenedor para los productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="product-list">
                <!-- Ciclo para mostrar los productos -->
                @foreach ($viewData['products'] as $product)
                    <div
                        class="group bg-white rounded-lg shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-lg h-[500px] flex flex-col">
                        <!-- Imagen del producto -->
                        <div class="relative h-80 md:h-[500px] overflow-hidden">
                            <img src="{{ asset('/img/' . $product->getImage()) }}" alt="{{ $product->getName() }}"
                                class="w-full h-full object-cover">
                            <!-- Superposición en hover -->
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300">
                            </div>
                        </div>

                        <!-- Detalles del producto -->
                        <div class="p-4 h-full flex flex-col justify-between">
                            <div class="flex-grow">
                                <!-- Nombre del producto -->
                                <h3 class="text-lg font-semibold text-gray-800 min-h-[50px]">{{ $product->getName() }}</h3>
                                <!-- Precio del producto -->
                                <p class="text-gray-600 mb-4">${{ number_format($product->getPrice(), 2) }}</p>
                            </div>
                            <!-- Botón de enlace al detalle del producto -->
                            <a href="{{ route('product.show', ['id' => $product->getId()]) }}"
                                class="inline-block w-full text-center bg-black text-white py-2 px-4 rounded-md transition-all duration-300 hover:bg-gray-800">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Indicador de carga -->
        <div id="loading" class="text-center py-8" style="display: none;">
            <span class="text-gray-500">Cargando más productos...</span>
        </div>
    </div>

    <script>
        // Variables globales para manejar la paginación y el estado de carga
        let skip = {{ count($viewData['products']) }};
        const limit = 9;
        let isLoading = false;

        // Función para cargar más productos
        function loadProducts() {
            // Evita que se carguen más productos si ya se está cargando
            if (isLoading) return;
            isLoading = true;

            // Muestra el indicador de carga
            const loading = document.getElementById('loading');
            loading.style.display = 'block';

            // Realiza la petición para cargar más productos
            fetch(`/load-more-products?skip=${skip}`)
                .then(response => response.json())
                .then(data => {
                    // Si hay productos nuevos, añádelos al DOM
                    if (data.length > 0) {
                        const productList = document.getElementById('product-list');
                        data.forEach(product => {
                            const productElement = document.createElement('div');
                            productElement.classList.add('group', 'bg-white', 'rounded-lg', 'shadow-md',
                                'overflow-hidden', 'transform', 'transition-all', 'duration-300',
                                'hover:scale-105', 'hover:shadow-lg', 'h-[500px]', 'flex', 'flex-col');

                            productElement.innerHTML = `
                                <div class="relative h-80 md:h-[500px] overflow-hidden">
                                    <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                                </div>
                                <div class="p-4 h-full flex flex-col justify-between">
                                    <div class="flex-grow">
                                        <h3 class="text-lg font-semibold text-gray-800 min-h-[50px]">${product.name}</h3>
                                        <p class="text-gray-600 mb-4">$${product.price.toFixed(2)}</p>
                                    </div>
                                    <a href="/products/${product.id}" class="inline-block w-full text-center bg-black text-white py-2 px-4 rounded-md transition-all duration-300 hover:bg-gray-800">
                                        Ver Detalles
                                    </a>
                                </div>
                            `;
                            productList.appendChild(productElement);
                        });
                        skip += limit;
                    }
                    // Oculta el indicador de carga
                    loading.style.display = 'none';
                    isLoading = false;
                })
                .catch(() => {
                    // Si hay error, oculta el indicador de carga
                    loading.style.display = 'none';
                    isLoading = false;
                });
        }

        // Detecta cuando el usuario llega al final de la página y carga más productos
        window.onscroll = function() {
            const scrollPosition = window.innerHeight + window.scrollY;
            const pageHeight = document.documentElement.scrollHeight - 100;

            if (scrollPosition >= pageHeight) {
                loadProducts();
            }
        };

        // Carga los primeros productos al cargar la página
        window.onload = loadProducts;
    </script>
@endsection
