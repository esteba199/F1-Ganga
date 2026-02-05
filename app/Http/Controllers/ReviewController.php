<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, \App\Models\Car $car)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '¡Gracias por tu reseña!');
    }
}
