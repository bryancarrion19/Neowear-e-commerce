<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Muestra todos los productos en la vista principal
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "NeoWear"; // Título de la página
        $viewData["subtitle"] = "Colección"; // Subtítulo de la página
        $viewData["products"] = Product::all(); // Obtiene todos los productos de la base de datos
        return view('product.index')->with("viewData", $viewData); // Pasa los datos a la vista
    }

    // Muestra los detalles de un producto individual
    public function show($id)
    {
        $viewData = [];

        // Busca el producto en la base de datos
        $product = Product::find($id);

        // Si no está en la BD, lo busca en la API
        if (!$product) {
            try {
                // Intentamos obtener el producto desde la API
                $client = new \GuzzleHttp\Client();
                $response = $client->get('https://dummyjson.com/products/' . $id);
                $data = json_decode($response->getBody(), true);

                // Si la API devuelve el producto
                if (isset($data['id'])) {
                    $product = new Product();
                    $product->setId($data['id']);
                    $product->setName($data['title']);
                    $product->setDescription($data['description']);
                    $product->setPrice($data['price']);
                    $product->setImage($data['images'][0]);
                } else {
                    // Si no se encuentra el producto
                    return redirect()->route('product.index')->with('error', 'Producto no encontrado.');
                }
            } catch (\Exception $e) {
                // Manejo del error si falla la conexión con la API
                Log::error('Error al conectar con la API: ' . $e->getMessage());
                return redirect()->route('product.index')->with('error', 'No se pudo obtener el producto.');
            }
        }

        // Si el producto es encontrado, muestra los detalles
        $viewData["title"] = $product->getName() . " - NeoWear";
        $viewData["subtitle"] = $product->getName() . " - Información del producto";
        $viewData["product"] = $product;
        $viewData["reviews"] = $product->reviews()->get() ?? [];

        return view('product.show')->with("viewData", $viewData);
    }

    // Carga más productos cuando el usuario desplaza hacia abajo
    public function loadMoreProducts(Request $request)
    {
        Log::error("Loading more products");

        // Validación de los parámetros de la solicitud
        $skip = $request->query('skip', 0); // Número de productos a omitir
        $limit = 9; // Número máximo de productos a cargar

        if (!is_numeric($skip)) {
            return response()->json(['error' => 'El parámetro "skip" debe ser un número.'], 400);
        }

        if (!is_numeric($limit)) {
            return response()->json(['error' => 'El parámetro "limit" debe ser un número.'], 400);
        }

        try {
            // Intenta obtener los productos desde la API externa
            $products = $this->fetchProductsFromApi($skip, $limit);
            return response()->json($products); // Devuelve los productos obtenidos
        } catch (\Exception $e) {
            // Maneja los errores si no se puede conectar a la API
            return response()->json(['error' => 'Error al obtener los productos.'], 500);
        }
    }

    // Función privada para obtener productos desde una API externa
    private function fetchProductsFromApi($skip, $limit)
    {
        $client = new Client();

        try {
            // Realiza una solicitud GET a la API externa
            $response = $client->get('https://dummyjson.com/products?skip=0&limit=9', [
                'query' => [
                    'skip' => $skip,  // Se utiliza "skip" en lugar de "offset"
                    'limit' => $limit
                ]
            ]);

            $data = json_decode($response->getBody(), true); // Decodifica la respuesta JSON de la API

            // Verifica si existen productos en la respuesta
            if (isset($data['products'])) {
                // Formatea los productos obtenidos
                $formattedProducts = array_map(function ($product) {
                    return [
                        'id' => $product['id'], // ID del producto
                        'name' => $product['title'], // Nombre del producto
                        'price' => $product['price'], // Precio del producto
                        'image' => $product['images'][0], // Primera imagen del producto
                    ];
                }, $data['products']);

                return $formattedProducts; // Devuelve los productos formateados
            } else {
                throw new \Exception('No se encontraron productos en la respuesta de la API.');
            }
        } catch (RequestException $e) {
            // Maneja los errores si hay problemas al conectarse con la API
            throw new \Exception('Error al conectar con la API: ' . $e->getMessage());
        }
    }
}
