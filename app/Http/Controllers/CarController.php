<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return view('cars.index');
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        //
    }

    public function destroy(Car $car)
    {
        //
    }
}
