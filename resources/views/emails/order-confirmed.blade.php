<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Pedido - F1 Ganga</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1a1a1a; color: #ffffff; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #2c2c2c; padding: 20px; border-radius: 8px; border: 1px solid #444; }
        h1 { color: #ffeb3b; text-align: center; }
        .details { margin-top: 20px; }
        .item { border-bottom: 1px solid #444; padding: 10px 0; display: flex; justify-content: space-between; }
        .total { font-size: 1.2em; font-weight: bold; margin-top: 20px; text-align: right; color: #ffeb3b; }
        .footer { margin-top: 30px; text-align: center; color: #888; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Gracias por tu compra!</h1>
        <p>Hola {{ $order->user->name }},</p>
        <p>Tu pedido ha sido confirmado y procesado correctamente.</p>
        
        <div class="details">
            <h3 style="border-bottom: 1px solid #ffeb3b; padding-bottom: 5px;">Detalles del Pedido #{{ $order->id }}</h3>
            
            @foreach($order->items as $item)
                <div class="item">
                    <span>
                        {{ $item->car->brand->name ?? '' }} {{ $item->car->model }} 
                        <span style="color: #ccc; font-size: 0.9em;">(x{{ $item->quantity }})</span>
                    </span>
                    <span>{{ number_format($item->price * $item->quantity, 2) }} €</span>
                </div>
            @endforeach
            
            <div class="total">
                Total: {{ number_format($order->total, 2) }} €
            </div>
        </div>

        <p style="margin-top: 20px;">
            Si tienes alguna pregunta, no dudes en contactarnos.
        </p>

        <div class="footer">
            &copy; {{ date('Y') }} F1 Ganga. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
