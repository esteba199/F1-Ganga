<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Team;
use App\Models\Brand;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Catálogo - Vista horizontal sin filtros
    public function index()
    {
        $cars = Car::with(['brand', 'team'])->latest()->paginate(10);
        return view('cars.index', compact('cars'));
    }

    // Búsqueda - Vista en cuadrícula con filtros
    public function search(Request $request)
    {
        $query = Car::with(['brand', 'team']);

        if ($request->filled('search')) {
            $query->where('model', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $cars = $query->paginate(12)->withQueryString();
        $years = Car::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('cars.search', compact('cars', 'years'));
    }





    public function show(Car $car)
    {
        $car->load(['brand', 'team', 'reviews.user']);
        return view('cars.show', compact('car'));
    }






}
