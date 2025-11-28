<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PacienteController extends Controller
{
    // ============================================================
    // LISTAR SOLO PACIENTES ACTIVOS
    // ============================================================
    public function index()
    {
        $pacientes = Paciente::where('estado', 'activo')
                             ->orderBy('id', 'desc')
                             ->get();

        return view('pacientes.index', compact('pacientes'));
    }

    // ============================================================
    // FORMULARIO CREAR
    // ============================================================
    public function create()
    {
        return view('pacientes.create');
    }

    // ============================================================
    // GUARDAR PACIENTE NUEVO
    // ============================================================
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:pacientes,nombre',
            'email'  => 'nullable|email',
            'foto'   => 'nullable|image|max:4096'
        ], [
            'nombre.unique' => 'Este paciente ya está registrado en el sistema.'
        ]);

        // Calcular edad automáticamente
        $edad = $request->filled('fecha_nacimiento')
            ? Carbon::parse($request->fecha_nacimiento)->age
            : null;

        $data = $request->all();
        $data['edad'] = $edad;
        $data['estado'] = 'activo';

        // FOTO SUBIDA MANUAL
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pacientes', 'public');
        }

        // FOTO DESDE CÁMARA (BASE64)
        if ($request->filled('foto_capturada')) {
            $imageName = 'pacientes/' . uniqid() . '.png';
            $base64 = base64_decode(
                str_replace('data:image/png;base64,', '', $request->foto_capturada)
            );
            Storage::disk('public')->put($imageName, $base64);
            $data['foto'] = $imageName;
        }

        Paciente::create($data);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    // ============================================================
    // MOSTRAR DETALLES DEL PACIENTE
    // ============================================================
    public function show($id)
    {
        $paciente = Paciente::with('consultas')->findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    // ============================================================
    // FORMULARIO EDITAR
    // ============================================================
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    // ============================================================
    // ACTUALIZAR PACIENTE
    // ============================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|unique:pacientes,nombre,' . $id,
            'email'  => 'nullable|email',
            'foto'   => 'nullable|image|max:4096'
        ], [
            'nombre.unique' => 'Ya existe otro paciente con este nombre.'
        ]);

        $paciente = Paciente::findOrFail($id);

        // Recalcular edad
        $edad = $request->filled('fecha_nacimiento')
            ? Carbon::parse($request->fecha_nacimiento)->age
            : null;

        $data = $request->all();
        $data['edad'] = $edad;

        // FOTO SUBIDA MANUAL
        if ($request->hasFile('foto')) {

            if ($paciente->foto) {
                Storage::disk('public')->delete($paciente->foto);
            }

            $data['foto'] = $request->file('foto')->store('pacientes', 'public');
        }

        // FOTO DESDE CÁMARA
        if ($request->filled('foto_capturada')) {

            if ($paciente->foto) {
                Storage::disk('public')->delete($paciente->foto);
            }

            $imageName = 'pacientes/' . uniqid() . '.png';
            $base64 = base64_decode(
                str_replace('data:image/png;base64,', '', $request->foto_capturada)
            );

            Storage::disk('public')->put($imageName, $base64);

            $data['foto'] = $imageName;
        }

        $paciente->update($data);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente.');
    }

    // ============================================================
    // "ELIMINAR" = MARCAR COMO INACTIVO
    // ============================================================
    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);

        // NO BORRAR FOTO
        // NO BORRAR CONSULTAS
        // NO BORRAR PACIENTE

        $paciente->estado = 'inactivo';
        $paciente->save();

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'El paciente fue marcado como inactivo.');
    }

    // ============================================================
    // REACTIVAR PACIENTE (Opcional)
    // ============================================================
    public function reactivar($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->estado = 'activo';
        $paciente->save();

        return back()->with('success', 'Paciente reactivado correctamente.');
    }
}
