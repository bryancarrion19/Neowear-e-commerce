@extends('layouts.app')

@section('title', $viewData['title']) <!-- Título de la página -->
@section('subtitle', $viewData['subtitle']) <!-- Subtítulo de la página -->

@section('content')
    <!-- Bucle para mostrar los pedidos, si existen -->
    @forelse ($viewData["orders"] as $order)
        <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
            <!-- Cabecera del pedido -->
            <div class="bg-gray-200 px-6 py-3 rounded-t-xl font-semibold text-gray-800 flex justify-between items-center">
                <!-- ID del pedido -->
                <span>Pedido #{{ $order->id }}</span>
                <!-- Fecha de creación del pedido -->
                <span class="text-sm text-gray-600">{{ $order->created_at }}</span>
            </div>

            <!-- Cuerpo del pedido -->
            <div class="p-6">
                <!-- Saludo al usuario -->
                <h1 class="text-2xl font-semibold">¡Gracias por tu compra, {{ $order->user->name }}!</h1>
                <p class="text-lg font-medium text-gray-700 mb-2">Tu pedido ha sido confirmado con éxito.</p>

                <!-- Detalles generales del pedido -->
                <p class="text-lg font-medium text-gray-700 mb-4"><strong>ID de pedido:</strong> {{ $order->id }}</p>
                <p class="text-lg font-medium text-gray-700 mb-4"><strong>Total:</strong> ${{ $order->total }}</p>

                <!-- Título de los detalles del pedido -->
                <h2 class="text-xl font-semibold mb-2">Detalles del pedido:</h2>

                <!-- Lista de los productos dentro del pedido -->
                <ul class="list-disc pl-5 space-y-2">
                    <!-- Bucle que recorre los artículos del pedido -->
                    @foreach ($order->items as $item)
                        <li>
                            <!-- Nombre del producto -->
                            <strong>{{ $item->product->name }}</strong><br>
                            <!-- Cantidad del producto -->
                            Cantidad: {{ $item->quantity }}<br>
                            <!-- Precio del producto -->
                            Precio: ${{ $item->price }}<br>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <!-- Mensaje en caso de que no haya pedidos -->
        <div class="bg-gray-100 text-gray-800 p-6 rounded-xl shadow-md text-center text-lg font-semibold" role="alert">
            Aún no has realizado ningún pedido.
        </div>
    @endforelse
@endsection
