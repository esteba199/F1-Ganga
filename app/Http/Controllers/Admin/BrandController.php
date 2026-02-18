<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Constructor con los middlewares de auth y admin
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    // Muestra la lista de marcas con filtros
    public function index(Request $request)
    {
        $query = Brand::query();

        // Aquí se filtra por nombre o país
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
        }

        $brands = $query->orderBy('name')
                       ->paginate(15)
                       ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    // Muestra el formulario para crear marca
    public function create()
    {
        return view('admin.brands.create');
    }

    // Guarda la marca nueva
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        Brand::create($data);

        return redirect()->route('admin.brands.index')
                       ->with('success', 'Marca creada correctamente.');
    }

    // Muestra el formulario para editar marca
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    // Actualiza la marca
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        $brand->update($data);

        return redirect()->route('admin.brands.index')
                       ->with('success', 'Marca actualizada correctamente.');
    }

    // Borra la marca
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')
                       ->with('success', 'Marca eliminada correctamente.');
    }
}
