@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Copias de Seguridad</h1>

        {{-- Botón para crear una nueva copia de seguridad --}}
        <form action="{{ route('admin.backup.create') }}" method="POST" class="text-center mb-6">
            @csrf
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                <i class="bi bi-plus-circle mr-2"></i> Crear Nueva Copia de Seguridad
            </button>
        </form>

        {{-- Mensajes de éxito o error --}}
        @if (session('success'))
            <div
                class="bg-green-100 text-green-800 border border-green-200 px-4 py-3 rounded relative mb-4 text-center animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="bg-red-100 text-red-800 border border-red-200 px-4 py-3 rounded relative mb-4 text-center animate__animated animate__fadeIn">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabla de copias de seguridad --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 uppercase text-sm text-left">Nombre del Archivo</th>
                        <th class="py-3 px-4 uppercase text-sm text-left">Tamaño</th>
                        <th class="py-3 px-4 uppercase text-sm text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($backups as $backup)
                        <tr class="border-b hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-4">{{ $backup['filename'] }}</td>
                            <td class="py-3 px-4">{{ $backup['size'] }}</td>
                            <td class="py-3 px-4 text-center space-x-2">
                                <a href="{{ $backup['url'] }}"
                                    class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                                    <i class="bi bi-download mr-1"></i> Descargar
                                </a>
                                <form action="{{ route('admin.backup.restore', $backup['filename']) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-300"
                                        onclick="return confirm('¿Seguro que deseas restaurar esta copia de seguridad?')">
                                        <i class="bi bi-arrow-clockwise mr-1"></i> Restaurar
                                    </button>
                                </form>
                                <form action="{{ route('admin.backup.delete', $backup['filename']) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300"
                                        onclick="return confirm('¿Seguro que deseas eliminar esta copia de seguridad?')">
                                        <i class="bi bi-trash mr-1"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-center text-gray-500">No hay copias de seguridad
                                disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
