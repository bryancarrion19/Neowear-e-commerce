<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MyAccountController extends Controller
{
    // Muestra los pedidos del usuario autenticado
    public function orders()
    {
        $viewData = [];
        $viewData["title"] = "Mis pedidos - Neowear"; // Título de la vista
        $viewData["subtitle"] = "Mis pedidos"; // Subtítulo de la vista

        // Obtener todos los pedidos del usuario autenticado, incluyendo los productos de cada pedido
        $viewData["orders"] = Order::with(['items.product'])
            ->where('user_id', Auth::user()->getId()) // Filtrar por el ID del usuario autenticado
            ->get();

        return view('myaccount.orders')->with("viewData", $viewData); // Pasar los datos a la vista de pedidos
    }

    // Muestra el perfil del usuario autenticado
    public function showProfile()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        return view('myaccount.perfil', compact('user')); // Pasar el usuario a la vista de perfil
    }

    // Añadir fondos al balance del usuario
    public function anadirFondos(Request $request)
    {
        // Validar que el saldo sea un número positivo
        $request->validate([
            'saldo' => 'required|numeric|min:1',
        ]);

        $user = Auth::user(); // Obtener el usuario autenticado
        $saldo = $request->input('saldo'); // Obtener el saldo ingresado
        $user->anadirFondos($saldo); // Añadir fondos al balance del usuario

        // Redirigir al perfil con mensaje de éxito
        return view("myaccount.perfil")
            ->with('success', 'Fondos añadidos exitosamente.') // Mensaje de éxito
            ->with('user', $user) // Pasar el usuario a la vista
            ->with('saldo', $saldo); // Pasar el saldo añadido
    }

    // Actualizar la foto de perfil del usuario
    public function actualizarFoto(Request $request)
    {
        // Validar que el archivo sea una imagen y su tamaño no exceda los 2MB
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user(); // Obtener el usuario autenticado

        // Si el usuario sube una nueva foto
        if ($request->hasFile('profile_picture')) {
            // Guardar la imagen en el directorio 'profiles' dentro del almacenamiento público
            $imagePath = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture = 'storage/' . $imagePath; // Actualizar la ruta de la foto de perfil
            $user->save(); // Guardar cambios en la base de datos
        }

        // Redirigir al perfil con mensaje de éxito
        return redirect()->route('myaccount.perfil')->with('success', 'Foto de perfil actualizada correctamente.');
    }

    // Muestra la vista principal del perfil del usuario
    public function index()
    {
        return view('myaccount.perfil'); // Asegúrate de que la vista existe
    }
}
