@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
        <div class="bg-green-500 text-white text-center py-4 text-lg font-semibold">
            ✨ Compra Completada!!
        </div>
        <div class="p-6">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p class="font-medium">Felicidades, tu compra ha sido completada.</p>
                <p class="mt-2 text-sm">Pedido número <span class="font-bold">#{{ $viewData['order']->getId() }}</span></p>
            </div>
        </div>
    </div>
@endsection
