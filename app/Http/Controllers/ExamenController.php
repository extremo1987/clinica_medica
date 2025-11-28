<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    /**
     * =============================================================
     * LISTA PARA TAGIFY (AUTO–COMPLETADO)
     * =============================================================
     * Devuelve SOLO un array de nombres, como:
     * ["Hemograma","Orina","Glucosa"]
     */
    public function list(Request $request)
    {
        $search = $request->query('q');

        $query = Examen::query();

        if ($search) {
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        // SOLO devolver el nombre, como Tagify necesita
        $examenes = $query->orderBy('nombre')
                          ->limit(20)
                          ->pluck('nombre');

        return response()->json($examenes);
    }


    /**
     * =============================================================
     * CRUD COMPLETO PARA ADMINISTRAR CATÁLOGO DE EXÁMENES
     * =============================================================
     */

    public function index()
    {
        $examenes = Examen::orderBy('nombre')->paginate(20);
        return view('examenes.index', compact('examenes'));
    }


    public function create()
    {
        return view('examenes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|unique:examenes,nombre',
            'categoria'   => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        Examen::create($request->all());

        return redirect()
            ->route('examenes.index')
            ->with('success', 'Examen agregado correctamente.');
    }


    public function edit(Examen $examen)
    {
        return view('examenes.edit', compact('examen'));
    }


    public function update(Request $request, Examen $examen)
    {
        $request->validate([
            'nombre'      => "required|unique:examenes,nombre,{$examen->id}",
            'categoria'   => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $examen->update($request->all());

        return redirect()
            ->route('examenes.index')
            ->with('success', 'Examen actualizado correctamente.');
    }


    public function destroy(Examen $examen)
    {
        $examen->delete();

        return redirect()
            ->route('examenes.index')
            ->with('success', 'Examen eliminado correctamente.');
    }
}
