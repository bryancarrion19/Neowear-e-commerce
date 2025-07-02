@extends('layouts.app') <!-- Extiende la plantilla base de la aplicación -->

@section('title', $viewData['title']) <!-- Define el título de la página -->
@section('subtitle', $viewData['subtitle']) <!-- Define el subtítulo de la página -->

@section('content') <!-- Comienza la sección de contenido principal -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-md">
        <!-- Encabezado del carrito de compras -->
        <div class="bg-gray-50 p-4 sm:p-6 text-xl font-semibold text-gray-800">
            <span class="es">Carrito</span> <!-- Título de la sección de carrito -->
        </div>

        <!-- Contenedor para los artículos del carrito, con un diseño en rejilla -->
        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Itera sobre los artículos del carrito -->
            @foreach ($viewData['cartItems'] as $item)
                <div
                    class="flex flex-col bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-300 p-4">
                    <!-- Imagen del producto -->
                    <img src="{{ asset('/img/' . $item->product->getImage()) }}" alt="{{ $item->product->getName() }}"
                        class="w-full h-40 sm:h-48 object-cover rounded-t-lg">
                    <div class="flex flex-col justify-between flex-grow mt-4">
                        <!-- Nombre del producto -->
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">{{ $item->product->getName() }}</h3>
                        <!-- ID del producto -->
                        <p class="text-xs sm:text-sm text-gray-600">ID: {{ $item->product->getId() }}</p>
                        <!-- Precio del producto -->
                        <p class="text-base sm:text-lg font-semibold text-gray-800">{{ $item->product->getPrice() }}€</p>
                        <div class="flex items-center justify-between mt-2">
                            <!-- Cantidad del producto en el carrito -->
                            <p class="text-sm text-gray-600">Cantidad: {{ $item->quantity }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sección con el total a pagar y botones de acción -->
        <div class="mt-6 p-4 sm:p-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center">
            <div class="text-base sm:text-lg font-medium text-gray-800">
                <b>Total a pagar:</b> {{ $viewData['total'] }}€ <!-- Muestra el total a pagar -->
            </div>

            @if (count($viewData['cartItems']) > 0)
                <!-- Solo muestra los botones si hay artículos en el carrito -->
                <div
                    class="space-y-4 sm:space-x-4 sm:space-y-0 mt-4 sm:mt-0 flex flex-col sm:flex-row justify-between items-center">
                    <!-- Contenedor para el botón de PayPal -->
                    <div id="paypal-button-container" class="mb-4 sm:mb-0"></div>

                    <!-- Enlace para finalizar la compra directamente -->
                    <a href="{{ route('cart.purchase') }}"
                        class="inline-block bg-black text-white px-4 sm:px-6 py-2 rounded-lg hover:bg-gray-800 transition duration-300">
                        <span class="es">Comprar ahora</span> <!-- Texto para el botón de compra -->
                    </a>

                    <!-- Enlace para restablecer el carrito -->
                    <a href="{{ route('cart.delete') }}">
                        <button
                            class="inline-block bg-red-500 text-white px-4 sm:px-6 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                            <span class="es">Restablecer carrito</span>
                            <!-- Texto para el botón de restablecer carrito -->
                        </button>
                    </a>

                    <!-- Enlace para seguir comprando -->
                    <a href="{{ route('product.index') }}"
                        class="inline-block bg-blue-500 text-white px-4 sm:px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                        Seguir comprando <!-- Texto para el botón de seguir comprando -->
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Incluir el script del SDK de PayPal con el client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&components=buttons"></script>

    <script>
        // Configuración del botón de PayPal
        paypal.Buttons({
            // Función para crear la orden de compra
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $viewData['total'] }}', // Usa el total calculado del carrito
                        },
                    }],
                });
            },
            // Función que se ejecuta después de aprobar el pago
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Alerta con el nombre del comprador y redirección
                    alert('Pago realizado con éxito por ' + details.payer.name.given_name);
                    window.location.href =
                        "{{ route('cart.purchase') }}"; // Redirige a la página de éxito
                });
            },
            // Función que se ejecuta si el pago es cancelado
            onCancel: function(data) {
                alert('El pago fue cancelado');
                window.location.href = "{{ route('cart.index') }}"; // Redirige a la página del carrito
            }
        }).render('#paypal-button-container'); // Renderiza el botón de PayPal
    </script>
@endsection
