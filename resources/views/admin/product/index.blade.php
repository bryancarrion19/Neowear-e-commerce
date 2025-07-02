@extends('layouts.admin')
@section('title', $viewData['title'])
@section('content')

    <div class="max-w-full mx-auto space-y-4 p-3 sm:p-4">

        <!-- Sección de Crear Producto -->
        <div class="bg-white shadow-lg p-3 sm:p-4 rounded-2xl">
            <h2 class="text-sm sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                ➕ Crear Producto
            </h2>

            @if ($errors->any())
                <ul class="mb-3 sm:mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs sm:text-sm">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 mb-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700">Nombre:</label>
                        <input name="name" value="{{ old('name') }}" type="text"
                            class="mt-1 p-2 sm:p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700">Precio (€):</label>
                        <input name="price" value="{{ old('price') }}" type="number"
                            class="mt-1 p-2 sm:p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700">Imagen:</label>
                    <input type="file" name="image"
                        class="mt-1 p-2 sm:p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50">
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700">Descripción:</label>
                    <textarea name="description" rows="3 sm:rows-4"
                        class="mt-1 p-2 sm:p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ old('description') }}</textarea>
                </div>

                <button type="submit"
                    class="mt-3 sm:mt-4 bg-blue-600 text-white px-4 py-2 sm:px-5 sm:py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    📤 Crear Producto
                </button>
            </form>
        </div>

        <!-- Sección de Gestión de Productos -->
        <div class="bg-white shadow-lg p-3 sm:p-4 rounded-2xl">
            <h2 class="text-sm sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                📦 Administrar Productos
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 shadow-sm rounded-lg text-xs sm:text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="py-2 px-3 sm:px-6 text-left text-xs sm:text-sm font-medium text-gray-600 hidden sm:table-cell">
                                ID
                            </th>
                            <th class="py-2 px-3 sm:px-6 text-left text-xs sm:text-sm font-medium text-gray-600">
                                Nombre
                            </th>
                            <th class="py-2 px-3 sm:px-6 text-left text-xs sm:text-sm font-medium text-gray-600">
                                Editar
                            </th>
                            <th class="py-2 px-3 sm:px-6 text-left text-xs sm:text-sm font-medium text-gray-600">
                                Eliminar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData['products'] as $product)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-2 px-3 sm:px-6 text-xs text-gray-700 hidden sm:table-cell">
                                    {{ $product->getId() }}
                                </td>
                                <td class="py-2 px-3 sm:px-6 text-xs text-gray-700">
                                    {{ $product->getName() }}
                                </td>
                                <td class="py-2 px-3 sm:px-6">
                                    <a href="{{ route('admin.product.edit', ['id' => $product->getId()]) }}"
                                        class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                                        ✏️
                                    </a>
                                </td>
                                <td class="py-2 px-3 sm:px-6">
                                    <form action="{{ route('admin.product.delete', $product->getId()) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
