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

    public function create()
    {
        $teams = Team::all();
        $brands = Brand::all();
        return view('cars.create', compact('teams', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'team_id' => 'required|exists:teams,id',
            'year' => 'required|integer|min:1920|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0|max:999999999.99',
            'description' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'top_speed' => 'nullable|integer|min:0|max:1000',
            'acceleration' => 'nullable|numeric|min:0|max:99.9',
            'engine' => 'nullable|string|max:255',
            'horsepower' => 'nullable|integer|min:0|max:5000',
            'transmission' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        Car::create($validated);

        return redirect()->route('cars.index')->with('success', '¡Coche añadido exitosamente!');
    }

    public function show(Car $car)
    {
        $car->load(['brand', 'team', 'reviews.user']);
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        $teams = Team::all();
        $brands = Brand::all();
        return view('cars.edit', compact('car', 'teams', 'brands'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'team_id' => 'required|exists:teams,id',
            'year' => 'required|integer|min:1920|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0|max:999999999.99',
            'description' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'top_speed' => 'nullable|integer|min:0|max:1000',
            'acceleration' => 'nullable|numeric|min:0|max:99.9',
            'engine' => 'nullable|string|max:255',
            'horsepower' => 'nullable|integer|min:0|max:5000',
            'transmission' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($car->image_url) {
                $oldPath = str_replace('/storage/', '', $car->image_url);
                \Storage::disk('public')->delete($oldPath);
            }
            
            $imagePath = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        $car->update($validated);

        return redirect()->route('cars.show', $car)->with('success', '¡Coche actualizado exitosamente!');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', '¡Coche eliminado exitosamente!');
    }
}
