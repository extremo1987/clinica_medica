<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\ConsultaArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PDF;

class ConsultaController extends Controller
{
    public function create($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        return view('consultas.create', compact('paciente'));
    }

    // ============================================================
    // GUARDAR CONSULTA (CORREGIDO)
    // ============================================================
    public function store(Request $request, $pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);

        // VALIDACIÓN BASE
        $data = $request->validate([
            'fecha_consulta' => 'nullable|date',
            'motivo' => 'nullable|string',

            'peso' => 'nullable|numeric',
            'estatura' => 'nullable|numeric',
            'presion_arterial' => 'nullable|string|max:20',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'temperatura' => 'nullable|numeric',
            'saturacion_o2' => 'nullable|integer',

            'diagnostico' => 'nullable|string',
            'cie10' => 'nullable|string|max:50',

            'tratamiento' => 'nullable|string',
            'receta' => 'nullable|string',

            // YA NO forzamos array → lo convertimos manualmente
            'examenes' => 'nullable',

            'dias_incapacidad' => 'nullable|integer',
            'incapacidad_inicio' => 'nullable|date',
            'incapacidad_fin' => 'nullable|date',
            'incapacidad_detalle' => 'nullable|string',

            'hospital_destino' => 'nullable|string',
            'motivo_remision' => 'nullable|string',
            'remision_detalle' => 'nullable|string',

            'monto' => 'nullable|numeric',
            'tipo_pago' => 'nullable|string|max:50',
            'pagado' => 'nullable',

            'archivos.*' => 'nullable|file|max:20480',
            'observaciones_archivo.*' => 'nullable|string',
        ]);

        // FECHA
        if (empty($data['fecha_consulta'])) {
            $data['fecha_consulta'] = Carbon::now();
        }

        // NORMALIZACIÓN DE PAGADO
        $data['pagado'] = $request->has('pagado') ? true : false;

        // NORMALIZAR EXÁMENES DESDE TAGIFY
        if (!empty($request->examenes)) {
            // si viene JSON string
            if (is_string($request->examenes)) {
                $decoded = json_decode($request->examenes, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    // convertir [{"value":"Hemograma"}] → ["Hemograma"]
                    $data['examenes'] = array_map(
                        fn($e) => $e['value'] ?? $e,
                        $decoded
                    );
                } else {
                    // caso extraño: texto separado por comas
                    $data['examenes'] = array_map('trim', explode(',', $request->examenes));
                }
            } else {
                $data['examenes'] = $request->examenes;
            }
        } else {
            $data['examenes'] = [];
        }

        // PREVENIR ERROR DE MONTO NULL
        $data['monto'] = $data['monto'] ?? 0;

        $data['paciente_id'] = $pacienteId;

        // CREAR CONSULTA
        $consulta = Consulta::create($data);

        // ==============================================
        // ARCHIVOS
        // ==============================================
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $i => $file) {

                if ($file && $file->isValid()) {
                    $ruta = $file->store('consultas_archivos', 'public');

                    ConsultaArchivo::create([
                        'consulta_id' => $consulta->id,
                        'nombre_archivo' => $file->getClientOriginalName(),
                        'ruta_archivo' => $ruta,
                        'tipo_archivo' => $file->getMimeType(),
                        'observacion' => $request->observaciones_archivo[$i] ?? null,
                    ]);
                }

            }
        }

        return redirect()
            ->route('pacientes.show', $pacienteId)
            ->with('success', 'Consulta registrada correctamente.');
    }

    // ============================================================
    // VER CONSULTA
    // ============================================================
    public function show($id)
    {
        $consulta = Consulta::with('archivos', 'paciente')->findOrFail($id);
        return view('consultas.show', compact('consulta'));
    }

    // ============================================================
    // EDITAR
    // ============================================================
    public function edit($id)
    {
        $consulta = Consulta::with('archivos')->findOrFail($id);
        $paciente = $consulta->paciente;

        return view('consultas.edit', compact('consulta', 'paciente'));
    }

    // ============================================================
    // ACTUALIZAR CONSULTA (CORREGIDO IGUAL QUE STORE)
    // ============================================================
    public function update(Request $request, $id)
    {
        $consulta = Consulta::findOrFail($id);

        $data = $request->validate([
            'fecha_consulta' => 'nullable|date',
            'motivo' => 'nullable|string',

            'peso' => 'nullable|numeric',
            'estatura' => 'nullable|numeric',
            'presion_arterial' => 'nullable|string|max:20',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'temperatura' => 'nullable|numeric',
            'saturacion_o2' => 'nullable|integer',

            'diagnostico' => 'nullable|string',
            'cie10' => 'nullable|string|max:50',

            'tratamiento' => 'nullable|string',
            'receta' => 'nullable|string',

            'examenes' => 'nullable',

            'dias_incapacidad' => 'nullable|integer',
            'incapacidad_inicio' => 'nullable|date',
            'incapacidad_fin' => 'nullable|date',
            'incapacidad_detalle' => 'nullable|string',

            'hospital_destino' => 'nullable|string',
            'motivo_remision' => 'nullable|string',
            'remision_detalle' => 'nullable|string',

            'monto' => 'nullable|numeric',
            'tipo_pago' => 'nullable|string|max:50',
            'pagado' => 'nullable',

            'archivos.*' => 'nullable|file|max:20480',
            'observaciones_archivo.*' => 'nullable|string',
        ]);

        $data['pagado'] = $request->has('pagado');

        if (!empty($request->examenes)) {
            if (is_string($request->examenes)) {
                $decoded = json_decode($request->examenes, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data['examenes'] = array_map(
                        fn($e) => $e['value'] ?? $e,
                        $decoded
                    );
                } else {
                    $data['examenes'] = array_map('trim', explode(',', $request->examenes));
                }
            } else {
                $data['examenes'] = $request->examenes;
            }
        } else {
            $data['examenes'] = [];
        }

        $data['monto'] = $data['monto'] ?? 0;

        $consulta->update($data);

        // ARCHIVOS
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $i => $file) {
                if ($file && $file->isValid()) {

                    $ruta = $file->store('consultas_archivos', 'public');

                    ConsultaArchivo::create([
                        'consulta_id' => $consulta->id,
                        'nombre_archivo' => $file->getClientOriginalName(),
                        'ruta_archivo' => $ruta,
                        'tipo_archivo' => $file->getMimeType(),
                        'observacion' => $request->observaciones_archivo[$i] ?? null,
                    ]);

                }
            }
        }

        return redirect()
            ->route('consultas.show', $consulta->id)
            ->with('success', 'Consulta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $pacienteId = $consulta->paciente_id;

        foreach ($consulta->archivos as $arch) {
            Storage::disk('public')->delete($arch->ruta_archivo);
        }

        $consulta->delete();

        return redirect()
            ->route('pacientes.show', $pacienteId)
            ->with('success', 'Consulta eliminada.');
    }

    public function descargarArchivo(ConsultaArchivo $archivo)
    {
        return Storage::disk('public')->download(
            $archivo->ruta_archivo,
            $archivo->nombre_archivo
        );
    }

    public function deleteArchivo(ConsultaArchivo $archivo)
    {
        Storage::disk('public')->delete($archivo->ruta_archivo);

        $consultaId = $archivo->consulta_id;
        $archivo->delete();

        return redirect()
            ->route('consultas.show', $consultaId)
            ->with('success', 'Archivo eliminado correctamente.');
    }

    public function pdfConsultaCompleta(Consulta $consulta)
    {
        $consulta->load('paciente', 'archivos');

        $pdf = PDF::loadView('pdf.consulta-completa', [
            'consulta' => $consulta
        ])->setPaper('letter', 'portrait');

        return $pdf->download('consulta_'.$consulta->id.'.pdf');
    }
}
