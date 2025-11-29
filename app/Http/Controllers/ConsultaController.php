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
    // ============================================================
    // CREAR CONSULTA
    // ============================================================
    public function create($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        return view('consultas.create', compact('paciente'));
    }

    // ============================================================
    // GUARDAR CONSULTA
    // ============================================================
    public function store(Request $request, $pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);

        $data = $request->validate([
            'fecha_consulta' => 'nullable|date',
            'motivo' => 'nullable|string',

            // Signos vitales
            'peso' => 'nullable|numeric',
            'estatura' => 'nullable|numeric',
            'presion_arterial' => 'nullable|string|max:20',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'temperatura' => 'nullable|numeric',
            'saturacion_o2' => 'nullable|integer',

            // Diagnóstico
            'diagnostico' => 'nullable|string',
            'cie10' => 'nullable|string|max:50',

            // Tratamiento / receta
            'tratamiento' => 'nullable|string',
            'receta' => 'nullable|string',

            // Exámenes
            'examenes' => 'nullable|array',

            // Incapacidad
            'dias_incapacidad' => 'nullable|integer',
            'incapacidad_inicio' => 'nullable|date',
            'incapacidad_fin' => 'nullable|date',
            'incapacidad_detalle' => 'nullable|string',

            // Remisión
            'hospital_destino' => 'nullable|string',
            'motivo_remision' => 'nullable|string',
            'remision_detalle' => 'nullable|string',

            // Pago
            'monto' => 'nullable|numeric',
            'tipo_pago' => 'nullable|string|max:50',
            'pagado' => 'nullable|boolean',

            // Archivos
            'archivos.*' => 'nullable|file|max:20480',
            'observaciones_archivo.*' => 'nullable|string',
        ]);

        // Fecha automática si no envían
        if (empty($data['fecha_consulta'])) {
            $data['fecha_consulta'] = Carbon::now();
        }

        $data['paciente_id'] = $pacienteId;
        $data['pagado'] = !empty($data['pagado']);
        $data['examenes'] = $data['examenes'] ?? [];

        // Crear consulta
        $consulta = Consulta::create($data);

        // ==========================
        // GUARDAR ARCHIVOS
        // ==========================
        $archivos = $request->file('archivos');

        if ($archivos && is_array($archivos)) {
            foreach ($archivos as $i => $file) {
                if (!$file) continue;

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

        return redirect()
            ->route('pacientes.show', $pacienteId)
            ->with('success', 'Consulta registrada correctamente.');
    }

    // ============================================================
    // MOSTRAR CONSULTA
    // ============================================================
    public function show($id)
    {
        $consulta = Consulta::with('archivos', 'paciente')->findOrFail($id);
        return view('consultas.show', compact('consulta'));
    }

    // ============================================================
    // EDITAR CONSULTA
    // ============================================================
    public function edit($id)
    {
        $consulta = Consulta::with('archivos')->findOrFail($id);
        $paciente = $consulta->paciente;

        return view('consultas.edit', compact('consulta', 'paciente'));
    }

    // ============================================================
    // ACTUALIZAR CONSULTA
    // ============================================================
    public function update(Request $request, $id)
    {
        $consulta = Consulta::findOrFail($id);

        $data = $request->validate([
            'fecha_consulta' => 'nullable|date',
            'motivo' => 'nullable|string',

            // Signos vitales
            'peso' => 'nullable|numeric',
            'estatura' => 'nullable|numeric',
            'presion_arterial' => 'nullable|string|max:20',
            'frecuencia_cardiaca' => 'nullable|integer',
            'frecuencia_respiratoria' => 'nullable|integer',
            'temperatura' => 'nullable|numeric',
            'saturacion_o2' => 'nullable|integer',

            // Diagnóstico
            'diagnostico' => 'nullable|string',
            'cie10' => 'nullable|string|max:50',

            // Tratamiento / receta
            'tratamiento' => 'nullable|string',
            'receta' => 'nullable|string',

            // Exámenes
            'examenes' => 'nullable|array',

            // Incapacidad
            'dias_incapacidad' => 'nullable|integer',
            'incapacidad_inicio' => 'nullable|date',
            'incapacidad_fin' => 'nullable|date',
            'incapacidad_detalle' => 'nullable|string',

            // Remisión
            'hospital_destino' => 'nullable|string',
            'motivo_remision' => 'nullable|string',
            'remision_detalle' => 'nullable|string',

            // Pago
            'monto' => 'nullable|numeric',
            'tipo_pago' => 'nullable|string|max:50',
            'pagado' => 'nullable|boolean',

            // Archivos
            'archivos.*' => 'nullable|file|max:20480',
            'observaciones_archivo.*' => 'nullable|string',
        ]);

        $data['pagado'] = !empty($data['pagado']);
        $data['examenes'] = $data['examenes'] ?? [];

        $consulta->update($data);

        // ==========================
        // ARCHIVOS NUEVOS
        // ==========================
        $archivos = $request->file('archivos');

        if ($archivos && is_array($archivos)) {
            foreach ($archivos as $i => $file) {
                if (!$file) continue;

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

        return redirect()
            ->route('consultas.show', $consulta->id)
            ->with('success', 'Consulta actualizada correctamente.');
    }

    // ============================================================
    // ELIMINAR CONSULTA
    // ============================================================
    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $pacienteId = $consulta->paciente_id;

        // borrar archivos
        foreach ($consulta->archivos as $arch) {
            Storage::disk('public')->delete($arch->ruta_archivo);
        }

        $consulta->delete();

        return redirect()
            ->route('pacientes.show', $pacienteId)
            ->with('success', 'Consulta eliminada.');
    }

    // ============================================================
    // DESCARGAR ARCHIVO
    // ============================================================
    public function descargarArchivo(ConsultaArchivo $archivo)
    {
        return Storage::disk('public')->download(
            $archivo->ruta_archivo,
            $archivo->nombre_archivo
        );
    }

    // ============================================================
    // ELIMINAR ARCHIVO
    // ============================================================
    public function deleteArchivo(ConsultaArchivo $archivo)
    {
        Storage::disk('public')->delete($archivo->ruta_archivo);

        $id = $archivo->consulta_id;
        $archivo->delete();

        return redirect()
            ->route('consultas.show', $id)
            ->with('success', 'Archivo eliminado.');
    }

    // ============================================================
    // PDF COMPLETO
    // ============================================================
    public function pdfConsultaCompleta(Consulta $consulta)
    {
        $consulta->load('paciente', 'archivos');

        $pdf = PDF::loadView('pdf.consulta-completa', [
            'consulta' => $consulta
        ])->setPaper('letter', 'portrait');

        return $pdf->download('consulta_'.$consulta->id.'.pdf');
    }
}
