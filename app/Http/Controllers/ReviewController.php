<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    // Método para almacenar una nueva reseña
    public function store(Request $request, $productId)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5', // La calificación debe ser un número entre 1 y 5
            'comment' => 'required|string|max:500', // El comentario debe ser una cadena de texto con un máximo de 500 caracteres
        ]);

        // Buscar el producto en la base de datos
        $product = Product::find($productId);

        // Si no se encuentra en la base de datos, intentamos obtenerlo desde la API
        if (!$product) {
            try {
                $client = new Client();
                $response = $client->get('https://dummyjson.com/products/' . $productId);
                $data = json_decode($response->getBody(), true);

                // Verifica si la API devolvió el producto
                if (isset($data['id'])) {
                    // Crear e insertar el producto en la base de datos
                    $product = new Product();
                    $product->id = $data['id'];
                    $product->name = $data['title'];
                    $product->description = $data['description'];
                    $product->price = $data['price'];
                    $product->image = $data['images'][0];
                    $product->save(); // Guarda el producto en la base de datos
                } else {
                    return redirect()->route('product.index')->with('error', 'Producto no encontrado.');
                }
            } catch (RequestException $e) {
                Log::error('Error al obtener el producto de la API: ' . $e->getMessage());
                return redirect()->route('product.index')->with('error', 'Error al conectar con la API.');
            }
        }

        // Crear la reseña
        $review = new Review();
        $review->product_id = $product->id; // Asegúrate de que el product_id existe en la base de datos
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save(); // Guarda la reseña en la base de datos

        // Redirigir al usuario de vuelta a la página del producto con la nueva reseña
        return redirect()->route('product.show', $productId);
    }

    // Método para mostrar todas las reseñas de un producto
    public function index($productId)
    {
        $viewData = [];

        // Intentamos obtener el producto desde la base de datos
        $product = Product::find($productId);

        // Si no se encuentra en la base de datos, intentar obtenerlo desde la API
        if (!$product) {
            try {
                $client = new Client();
                $response = $client->get('https://dummyjson.com/products/' . $productId);
                $data = json_decode($response->getBody(), true);

                // Verifica si la API devolvió el producto
                if (isset($data['id'])) {
                    // Crear una instancia del modelo Product
                    $product = new Product();
                    $product->id = $data['id'];
                    $product->name = $data['title'];
                    $product->description = $data['description'];
                    $product->price = $data['price'];
                    $product->image = $data['images'][0];
                } else {
                    return redirect()->route('product.index')->with('error', 'Producto no encontrado.');
                }
            } catch (RequestException $e) {
                Log::error('Error al obtener el producto de la API: ' . $e->getMessage());
                return redirect()->route('product.index')->with('error', 'Error al conectar con la API.');
            }
        }

        // Obtener las reseñas si el producto existe
        $reviews = $product->reviews()->get();

        // Pasar los datos del producto y las reseñas a la vista
        $viewData['product'] = $product;
        $viewData['reviews'] = $reviews;

        return view('reviews.show')->with("viewData", $viewData);
    }
}
