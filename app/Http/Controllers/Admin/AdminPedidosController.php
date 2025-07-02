<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminPedidosController extends Controller
{
    //
    public function index()
    {
        // Obtener todos los pedidos, puedes usar paginación si tienes muchos pedidos
        $pedidos = Order::all();  // Si prefieres paginación, usa ->paginate(15)

        // Retornar la vista con los pedidos
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        // Buscar el pedido por su ID, incluyendo los productos relacionados
        $pedido = Order::with('products')->findOrFail($id);

        // Retornar la vista con los detalles del pedido
        return view('admin.pedidos.show', compact('pedido'));
    }
}
