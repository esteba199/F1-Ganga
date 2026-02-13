<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f; /* F1 Red-ish */
        }
        .details td {
            padding: 5px;
        }
        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        table td {
            padding: 5px;
            vertical-align: top;
        }
        .heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .item td {
            border-bottom: 1px solid #eee;
        }
        .total td {
            border-top: 2px solid #333;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                F1 Ganga
                            </td>
                            <td class="text-right">
                                Factura #: {{ $order->id }}<br>
                                Fecha: {{ $order->created_at->format('d/m/Y') }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>Vendedor:</strong><br>
                                F1 Ganga Inc.<br>
                                123 Paddock Lane<br>
                                Mónaco
                            </td>
                            <td class="text-right">
                                <strong>Cliente:</strong><br>
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Item</td>
                <td class="text-right">Precio</td>
                <td class="text-right">Cantidad</td>
                <td class="text-right">Total</td>
            </tr>

            @foreach($order->items as $item)
            <tr class="item">
                <td>
                    {{ $item->car->brand->name ?? '' }} {{ $item->car->model }}
                    <br>
                    <small>{{ $item->car->team->name ?? '' }}</small>
                </td>
                <td class="text-right">{{ number_format($item->price, 2) }} €</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->price * $item->quantity, 2) }} €</td>
            </tr>
            @endforeach

            <tr class="total">
                <td colspan="3" class="text-right">Total:</td>
                <td class="text-right">{{ number_format($order->total, 2) }} €</td>
            </tr>
            
            @if($order->status === 'refunded')
            <tr class="total" style="color: red;">
                <td colspan="3" class="text-right">ESTADO:</td>
                <td class="text-right">REEMBOLSADO</td>
            </tr>
            @endif
        </table>
        
        <br>
        <p style="text-align: center; color: #777; font-size: 12px;">
            Gracias por comprar en F1 Ganga.
        </p>
    </div>
</body>
</html>
