@extends('layouts.admin')
@section('title', $viewData['title'])
@section('content')

    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Cards de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Pedidos -->
        <div
            class="bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl shadow-2xl p-6 hover:shadow-lg transition-shadow duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-sm font-light text-blue-100">Total Pedidos</div>
                    <div class="text-3xl font-bold">{{ $viewData['totalOrders'] }}</div>
                </div>
                <i class="fas fa-shopping-cart text-4xl text-blue-100 opacity-80"></i>
            </div>
        </div>

        <!-- Ventas Totales -->
        <div
            class="bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl shadow-2xl p-6 hover:shadow-lg transition-shadow duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-sm font-light text-green-100">Ventas Totales</div>
                    <div class="text-3xl font-bold">{{ number_format($viewData['totalSales'], 2) }}€</div>
                </div>
                <i class="fas fa-euro-sign text-4xl text-green-100 opacity-80"></i>
            </div>
        </div>

        <!-- Total Productos -->
        <div
            class="bg-gradient-to-r from-yellow-600 to-yellow-500 text-white rounded-xl shadow-2xl p-6 hover:shadow-lg transition-shadow duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-sm font-light text-yellow-100">Total Productos</div>
                    <div class="text-3xl font-bold">{{ $viewData['totalProducts'] }}</div>
                </div>
                <i class="fas fa-box text-4xl text-yellow-100 opacity-80"></i>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div
            class="bg-gradient-to-r from-purple-600 to-purple-500 text-white rounded-xl shadow-2xl p-6 hover:shadow-lg transition-shadow duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-sm font-light text-purple-100">Total Usuarios</div>
                    <div class="text-3xl font-bold">{{ $viewData['totalUsers'] }}</div>
                </div>
                <i class="fas fa-users text-4xl text-purple-100 opacity-80"></i>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Gráfico de Ventas Mensuales -->
        <div
            class="bg-white rounded-xl shadow-2xl p-6 hover:shadow-lg transition-shadow duration-300 transform hover:scale-101">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-chart-line mr-3 text-blue-500"></i>
                    Ventas Mensuales
                </h2>
            </div>
            <canvas id="monthlySalesChart"></canvas>
        </div>

        <!-- Top Productos -->
        <div
            class="bg-white rounded-xl shadow-2xl p-6 hover:shadow-lg transition-shadow duration-300 transform hover:scale-101">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-chart-pie mr-3 text-green-500"></i>
                    Productos Más Vendidos
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                Producto
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                Cantidad
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($viewData['topProducts'] as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script para los gráficos -->
    <script>
        // Gráfico de Ventas Mensuales
        var ctx = document.getElementById('monthlySalesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($viewData['monthlyLabels']),
                datasets: [{
                    label: 'Ventas (€)',
                    data: @json($viewData['monthlySales']),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
