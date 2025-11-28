<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExamenController; // <–– NUEVO


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// LOGIN → DASHBOARD
Route::get('/', fn() => redirect('/login'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth'])
    ->name('dashboard');


// =======================================================================
// ÁREA PRIVADA
// =======================================================================
Route::middleware('auth')->group(function () {

    // -------------------------------------------------------------------
    // PERFIL
    // -------------------------------------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ===================================================================
    // PDFS DE CONSULTA (RECETA / INCAPACIDAD / REMISIÓN)
    // ===================================================================
    Route::post('/pdf/receta/{paciente}', 
        [ConsultaController::class, 'recetaPDF'])
        ->name('consultas.receta.pdf');

    Route::post('/pdf/incapacidad/{paciente}', 
        [ConsultaController::class, 'incapacidadPDF'])
        ->name('consultas.incapacidad.pdf');

    Route::post('/pdf/remision/{paciente}', 
        [ConsultaController::class, 'remisionPDF'])
        ->name('consultas.remision.pdf');


    // ===================================================================
    // MÓDULO PACIENTES
    // ===================================================================
    Route::resource('pacientes', PacienteController::class);


    // ===================================================================
    // MÓDULO CONSULTAS
    // ===================================================================

    // PDF de consulta completa
    Route::get('/consultas/{consulta}/pdf', 
        [ConsultaController::class, 'pdfConsultaCompleta'])
        ->name('consultas.pdf.completa');

    // Crear
    Route::get('/pacientes/{paciente}/consultas/create', 
        [ConsultaController::class, 'create'])
        ->name('consultas.create');

    // Guardar
    Route::post('/pacientes/{paciente}/consultas', 
        [ConsultaController::class, 'store'])
        ->name('consultas.store');

    // Ver
    Route::get('/consultas/{consulta}', 
        [ConsultaController::class, 'show'])
        ->name('consultas.show');

    // Editar
    Route::get('/consultas/{consulta}/edit', 
        [ConsultaController::class, 'edit'])
        ->name('consultas.edit');

    // Actualizar
    Route::put('/consultas/{consulta}', 
        [ConsultaController::class, 'update'])
        ->name('consultas.update');

    // Eliminar
    Route::delete('/consultas/{consulta}', 
        [ConsultaController::class, 'destroy'])
        ->name('consultas.destroy');


    // ===================================================================
    // ARCHIVOS SUBIDOS EN CONSULTA
    // ===================================================================

    // Descargar archivo adjunto
    Route::get('/consultas/archivo/descargar/{archivo}',
        [ConsultaController::class, 'descargarArchivo'])
        ->name('consultas.archivo.descargar');

    // Eliminar archivo adjunto
    Route::delete('/consultas/archivo/{archivo}',
        [ConsultaController::class, 'deleteArchivo'])
        ->name('consultas.archivo.delete');


    // ===================================================================
    // AUTO–COMPLETADO DE EXÁMENES (TAGIFY)
    // ===================================================================
    Route::get('/examenes/list',
        [ExamenController::class, 'list'])
        ->name('examenes.list');

    // ===================================================================
    // CRUD ADMINISTRABLE DE EXÁMENES
    // ===================================================================
    Route::resource('examenes', ExamenController::class);


    // ===================================================================
    // MÓDULO USUARIOS
    // ===================================================================
    Route::resource('users', UserController::class);


    // ===================================================================
    // MÓDULO ROLES
    // ===================================================================
    Route::resource('roles', RoleController::class)->except(['show']);

    Route::get('/roles/{role}/permissions',
        [RoleController::class, 'editPermissions'])
        ->name('roles.permissions.edit');

    Route::put('/roles/{role}/permissions',
        [RoleController::class, 'updatePermissions'])
        ->name('roles.permissions.update');


    // ===================================================================
    // MÓDULO PERMISOS
    // ===================================================================
    Route::resource('permissions', PermissionController::class)->except(['show']);


    // ===================================================================
    // CONFIGURACIÓN
    // ===================================================================
    Route::get('/configuracion', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::post('/configuracion', [SettingController::class, 'update'])
        ->name('settings.update');
});


// AUTENTICACIÓN
require __DIR__.'/auth.php';
