<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>F1 Ganga - Factura</h1>
        <p>Orden #{{ $order->id }}</p>
        <p>Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="details">
        <strong>Cliente:</strong> {{ $order->user->name }}<br>
        <strong>Email:</strong> {{ $order->user->email }}<br>
        <strong>Estado:</strong> {{ ucfirst($order->status) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->car->brand->name }} {{ $item->car->model }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} €</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
                <td>{{ number_format($order->total, 2) }} €</td>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 50px; text-align: center; color: #777;">
        <p>Gracias por tu compra en F1 Ganga.</p>
    </div>
</body>
</html>
