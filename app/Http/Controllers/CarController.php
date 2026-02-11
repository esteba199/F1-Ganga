<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Team;
use App\Models\Brand;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with(['brand', 'team'])->latest()->get();
        return view('cars.index', compact('cars'));
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
            'year' => 'required|integer|min:1950|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
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
            'year' => 'required|integer|min:1950|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
