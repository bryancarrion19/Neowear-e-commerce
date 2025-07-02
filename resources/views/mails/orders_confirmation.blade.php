<!DOCTYPE html>
<html>

<head>
    <title>Confirmación de Pedido</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            color: #444;
            font-size: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .order-details ul {
            list-style: none;
            padding: 0;
        }

        .order-details ul li {
            padding: 8px 0;
            border-bottom: 1px solid #eaeaea;
        }

        .order-details ul li:last-child {
            border-bottom: none;
        }

        .order-details strong {
            color: #333;
        }

        .footer {
            background-color: #f4f4f9;
            text-align: center;
            padding: 15px;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado del email -->
        <div class="header">
            <h1>¡Gracias por tu compra, {{ $order->user->name }}!</h1>
        </div>

        <!-- Contenido principal del email -->
        <div class="content">
            <p>Tu pedido #{{ $order->id }} ha sido confirmado.</p>
            <p><strong>Total:</strong> ${{ $order->total }}</p>

            <h2>Detalles del pedido:</h2>
            <div class="order-details">
                <ul>
                    @foreach ($order->items as $item)
                        <li>
                            <strong>{{ $item->product->name }}</strong> - {{ $item->quantity }} x ${{ $item->price }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <p>Tu pedido llegará pronto.</p>
        </div>

        <!-- Pie de página del email -->
        <div class="footer">
            © 2025 NeoWear. Todos los derechos reservados.
        </div>
    </div>
</body>

</html>
