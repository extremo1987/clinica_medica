<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // si no existe, crear fila vacía
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([]);
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre_clinica' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
            'doctor' => 'nullable|string|max:255',
            'registro_medico' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'mostrar_logo_recetas' => 'nullable|in:0,1',
            'mostrar_direccion_recetas' => 'nullable|in:0,1',
            'footer_pdf' => 'nullable|string',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([]);
        }

        // campos simples
        $setting->nombre_clinica = $request->nombre_clinica;
        $setting->telefono = $request->telefono;
        $setting->whatsapp = $request->whatsapp;
        $setting->email = $request->email;
        $setting->direccion = $request->direccion;

        $setting->doctor = $request->doctor;
        $setting->registro_medico = $request->registro_medico;
        $setting->especialidad = $request->especialidad;

        $setting->mostrar_logo_recetas = $request->has('mostrar_logo_recetas') ? (int)$request->mostrar_logo_recetas : 0;
        $setting->mostrar_direccion_recetas = $request->has('mostrar_direccion_recetas') ? (int)$request->mostrar_direccion_recetas : 0;
        $setting->footer_pdf = $request->footer_pdf;

        // logo: si envían nuevo, guardarlo y eliminar anterior opcionalmente
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('public/settings'); // guarda en storage/app/public/settings
            // eliminar logo anterior
            if (!empty($setting->logo) && Storage::exists('public/'.$setting->logo)) {
                Storage::delete('public/'.$setting->logo);
            }
            // guardamos la ruta relativa para asset('storage/...') -> storage/app/public/...
            // al guardar $path viene como "public/settings/archivo.jpg", guardamos sin "public/"
            $setting->logo = str_replace('public/', '', $path);
        }

        $setting->save();

        return redirect()->route('settings.index')->with('success','Configuración guardada correctamente.');
    }
}
