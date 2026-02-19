<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Team;
use App\Services\LocalImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    protected $images;

    public function __construct(LocalImageService $images)
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
        $this->images = $images;
    }

    /**
     * Listado con paginación y filtros.
     */
    public function index(Request $request)
    {
        $query = Car::withTrashed()->with(['brand', 'team']);

        // Filtros: brand_id, team_id, search
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        if ($request->filled('team_id')) {
            $query->where('team_id', $request->input('team_id'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('model', 'like', "%{$q}%");
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $brands = Brand::orderBy('name')->get();
        $teams = Team::orderBy('name')->get();

        return view('admin.cars.index', compact('cars', 'brands', 'teams'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $teams = Team::orderBy('name')->get();
        return view('admin.cars.create', compact('brands', 'teams'));
    }

    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();

        // Si viene imagen subida, procesarla y obtener URL
        if ($request->hasFile('image')) {
            $data['image_url'] = $this->images->store($request->file('image'));
        } else {
            $data['image_url'] = 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&h=600&fit=crop';
        }

        $car = Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Coche creado correctamente.');
    }

    public function edit(Car $car)
    {
        $brands = Brand::orderBy('name')->get();
        $teams = Team::orderBy('name')->get();
        return view('admin.cars.edit', compact('car', 'brands', 'teams'));
    }

    // Actualiza un coche
    public function update(UpdateCarRequest $request, Car $car)
    {
        $data = $request->validated();

        // Si hay imagen nueva, la subimos y borramos la anterior
        if ($request->hasFile('image')) {
            if ($car->image_url) {
                $this->images->deleteByUrl($car->image_url);
            }
            $data['image_url'] = $this->images->store($request->file('image'));
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Coche actualizado.');
    }

    public function destroy(Car $car)
    {
        // Soft delete
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Coche eliminado (soft).');
    }

    public function restore($id)
    {
        $car = Car::withTrashed()->findOrFail($id);
        $car->restore();
        return redirect()->route('admin.cars.index')->with('success', 'Coche restaurado.');
    }

    public function forceDelete($id)
    {
        $car = Car::withTrashed()->findOrFail($id);
        // borrar imagen fisicamente
        if ($car->image_url) {
            $this->images->deleteByUrl($car->image_url);
        }
        $car->forceDelete();
        return redirect()->route('admin.cars.index')->with('success', 'Coche eliminado permanentemente.');
    }
}
