<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Car;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Ver carrito
    public function index()
    {
        $cartItems = Cart::with('car.brand', 'car.team')
            ->where('user_id', auth()->id())
            ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->car->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Añadir al carrito
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'quantity' => 'integer|min:1|max:10',
        ]);

        $car = Car::findOrFail($request->car_id);
        
        // Verificar si ya está en el carrito
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('car_id', $request->car_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity ?? 1);
            $msg = 'Cantidad actualizada en el carrito';
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'car_id' => $request->car_id,
                'quantity' => $request->quantity ?? 1,
            ]);
            $msg = '¡Coche añadido al carrito!';
        }

        if ($request->ajax()) {
            $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => $msg,
                'cartCount' => $cartCount
            ]);
        }

        return back()->with('success', $msg);
    }

    // Actualizar cantidad
    public function update(Request $request, Cart $cart)
    {
        // Verificar que el item pertenece al usuario
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:0|max:10',
        ]);

        if ($request->quantity <= 0) {
            $cart->delete();
            return back()->with('success', 'Producto eliminado del carrito');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cantidad actualizada');
    }

    // Eliminar del carrito
    public function destroy(Cart $cart)
    {
        // Verificar que el item pertenece al usuario
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Eliminado del carrito');
    }

    // Vaciar carrito
    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Carrito vaciado');
    }
}
