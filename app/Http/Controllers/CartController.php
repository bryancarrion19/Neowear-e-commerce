<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CartController extends Controller
{
    // Constructor que asegura que solo los usuarios autenticados puedan acceder a los métodos
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Muestra el carrito con los productos añadidos y el total
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Carrito - Neowear"; // Título de la página
        $viewData["subtitle"] = "Carrito"; // Subtítulo de la página

        // Obtenemos los productos del carrito del usuario
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product') // Cargar los productos relacionados
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->getPrice() * $item->quantity; // Calculamos el total
        }

        $viewData["total"] = $total; // Guardamos el total
        $viewData["cartItems"] = $cartItems; // Guardamos los productos del carrito

        return view('cart.index')->with("viewData", $viewData); // Retornamos la vista del carrito
    }

    // Añade o actualiza un producto en el carrito
    public function add(Request $request, $id)
    {
        $quantity = $request->input('quantity'); // Obtenemos la cantidad del producto

        // Buscamos si el producto ya está en el carrito
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            // Si ya existe, actualizamos la cantidad
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Si no existe, lo creamos
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => $quantity
            ]);
        }

        return redirect()->route('cart.index'); // Redirigimos al carrito
    }

    // Elimina todos los productos del carrito
    public function delete()
    {
        CartItem::where('user_id', Auth::id())->delete(); // Eliminamos los productos del carrito
        return back(); // Volvemos a la página anterior
    }

    // Maneja la compra del carrito, ya sea por PayPal o pago tradicional
    public function purchase(Request $request)
    {
        $isPaypal = $request->input('paypal', false); // Verificamos si es compra con PayPal

        // Obtenemos los productos del carrito
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        // Si el carrito está vacío, redirigimos al carrito
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // Creamos una nueva orden
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = 0; // Inicializamos el total
        $order->save(); // Guardamos la orden

        $total = 0;

        // Añadimos los productos a la orden
        foreach ($cartItems as $cartItem) {
            $orderItem = new Item();
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->product->getPrice();
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->order_id = $order->getId(); // Asignamos la orden
            $orderItem->save(); // Guardamos el item
            $total += $orderItem->price * $orderItem->quantity; // Calculamos el total
        }

        // Verificamos si el usuario tiene suficientes fondos
        $user = Auth::user();
        if ($user->balance < $total) {
            // Si no tiene suficientes fondos, mostramos un mensaje de error
            return redirect()->route('cart.index')->with('error', 'No tienes suficiente saldo para completar la compra.');
        }

        // Restamos el dinero del saldo del usuario
        $user->balance -= $total;
        $user->save();

        // Actualizamos el total de la orden
        $order->total = $total;
        $order->save(); // Guardamos la orden

        // Enviamos un correo de confirmación al usuario
        Mail::to($user->email)->send(new OrderConfirmation($order));

        // Limpiamos el carrito después de la compra
        CartItem::where('user_id', Auth::id())->delete();

        // Redirigimos según el tipo de pago
        if ($isPaypal) {
            return redirect()->route('cart.purchase'); // Redirigimos a la página de éxito de PayPal
        }

        // Vista de confirmación de compra
        $viewData = [];
        $viewData["title"] = "Compra - Online Store"; // Título de la página
        $viewData["subtitle"] = "Estado de la Compra"; // Subtítulo de la página
        $viewData["order"] = $order; // Pasamos la orden a la vista

        return view('cart.purchase')->with("viewData", $viewData); // Mostramos la vista de confirmación
    }
}
