<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use App\Models\Car;
use App\Models\User;
use Illuminate\Routing\Controller;

class ReviewController extends Controller
{
    // Constructor con los middlewares de auth y admin
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Muestra la lista de reseñas con filtros
    public function index()
    {
        // Buscar por comentario o usuario
        $query = Review::with(['user', 'car']);

        if ($search = request('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhere('comment', 'like', "%{$search}%");
        }

        // Filtrar por coche
        if ($carId = request('car_id')) {
            $query->where('car_id', $carId);
        }

        // Filtrar por puntuación
        if ($rating = request('rating')) {
            $query->where('rating', $rating);
        }

        $reviews = $query->orderBy('created_at', 'desc')
                         ->paginate(15)
                         ->withQueryString();

        $cars = Car::pluck('model', 'id'); // Para el select de coches

        return view('admin.reviews.index', compact('reviews', 'cars'));
    }

    // Muestra el formulario para crear reseña
    public function create()
    {
        $users = User::pluck('name', 'id');
        $cars = Car::pluck('model', 'id');

        return view('admin.reviews.create', compact('users', 'cars'));
    }

    // Guarda la reseña nueva
    public function store(StoreReviewRequest $request)
    {
        Review::create($request->validated());

        return redirect()->route('admin.reviews.index')
                        ->with('success', 'Reseña creada correctamente.');
    }

    // Muestra el formulario para editar reseña
    public function edit(Review $review)
    {
        $users = User::pluck('name', 'id');
        $cars = Car::pluck('model', 'id');

        return view('admin.reviews.edit', compact('review', 'users', 'cars'));
    }

    // Actualiza la reseña
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return redirect()->route('admin.reviews.index')
                        ->with('success', 'Reseña actualizada correctamente.');
    }

    // Borra la reseña (soft delete)
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
                        ->with('success', 'Reseña eliminada correctamente.');
    }
}
