@extends('layouts.admin')
@section('title', $viewData['title'])
@section('content')

    <div class="max-w-3xl mx-auto bg-white shadow-xl p-6 rounded-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            ✏️ Editar Producto
        </h2>

        @if ($errors->any())
            <ul class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('admin.product.update', ['id' => $viewData['product']->getId()]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nombre:</label>
                    <input name="name" value="{{ $viewData['product']->getName() }}" type="text"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Precio (€):</label>
                    <input name="price" value="{{ $viewData['product']->getPrice() }}" type="number"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Imagen:</label>
                <input type="file" name="image"
                    class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Descripción:</label>
                <textarea name="description" rows="4"
                    class="mt-1 p-3 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $viewData['product']->getDescription() }}</textarea>
            </div>

            <button type="submit"
                class="mt-4 bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                💾 Guardar Cambios
            </button>
        </form>
    </div>

@endsection
