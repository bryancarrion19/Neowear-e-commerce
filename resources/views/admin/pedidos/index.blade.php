@extends('layouts.admin')

@section('content')
    <div class="container mx-auto my-6 p-4 bg-white shadow-xl rounded-2xl">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
            📦 Listado de Pedidos
        </h1>

        <!-- Contenedor con scroll horizontal -->
        <div class="overflow-x-auto">
            <div class="min-w-[360px] lg:min-w-full"> <!-- Ajustamos el tamaño mínimo para pantallas grandes -->
                <table class="w-full bg-white border border-gray-200 shadow-md rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="py-0.5 px-1 text-left text-xs lg:text-sm font-semibold text-gray-700 hidden sm:table-cell">
                                ID Pedido</th>
                            <th class="py-0.5 px-1 text-left text-xs lg:text-sm font-semibold text-gray-700">Cliente</th>
                            <th class="py-0.5 px-1 text-left text-xs lg:text-sm font-semibold text-gray-700">Fecha</th>
                            <th class="py-0.5 px-1 text-left text-xs lg:text-sm font-semibold text-gray-700">Producto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="py-0.5 px-1 text-gray-800 text-xs hidden sm:table-cell lg:text-sm">
                                    {{ $pedido->id }}</td>
                                <td class="py-0.5 px-1 text-gray-800 text-xs lg:text-sm">{{ $pedido->user->name }}</td>
                                <td class="py-0.5 px-1 text-gray-800 text-xs lg:text-sm">
                                    {{ $pedido->created_at->format('d-m-Y') }}</td>
                                <td class="py-0.5 px-1 text-xs lg:text-sm">
                                    <ul class="flex gap-1 sm:gap-2 overflow-x-auto">
                                        @foreach ($pedido->items as $item)
                                            <li class="flex flex-col sm:flex-row items-center gap-1 sm:gap-2">
                                                <img src="{{ $item->product->getImageUrl() }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 object-cover rounded-md">
                                                <div class="max-w-[90px] sm:max-w-[120px] lg:max-w-[150px]">
                                                    <p class="text-xs sm:text-sm lg:text-base">{{ $item->product->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 lg:text-sm">${{ $item->product->price }}
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
