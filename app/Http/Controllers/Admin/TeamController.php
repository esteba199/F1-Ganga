<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Constructor con los middlewares de auth y admin
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    // Muestra la lista de equipos con filtros
    public function index(Request $request)
    {
        $query = Team::query();

        // Aquí se filtra por nombre o principal
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('principal', 'like', "%{$search}%");
        }

        $teams = $query->orderBy('name')
                      ->paginate(15)
                      ->withQueryString();

        return view('admin.teams.index', compact('teams'));
    }

    // Muestra el formulario para crear equipo
    public function create()
    {
        return view('admin.teams.create');
    }

    // Guarda el equipo nuevo
    public function store(StoreTeamRequest $request)
    {
        $data = $request->validated();
        Team::create($data);

        return redirect()->route('admin.teams.index')
                       ->with('success', 'Equipo creado correctamente.');
    }

    // Muestra el formulario para editar equipo
    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    // Actualiza el equipo
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $data = $request->validated();
        $team->update($data);

        return redirect()->route('admin.teams.index')
                       ->with('success', 'Equipo actualizado correctamente.');
    }

    // Borra el equipo
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')
                       ->with('success', 'Equipo eliminado correctamente.');
    }
}
