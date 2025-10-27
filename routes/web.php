<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\VolunteerAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

// Landing + elección de accesos
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Login Admin
Route::middleware('web')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
});

// Admin dashboard protegido
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // CRUDs del administrador
    Route::resource('personas', \App\Http\Controllers\Admin\PersonaController::class);
    Route::resource('partidos', \App\Http\Controllers\Admin\PartidoController::class)->except(['show']);
    Route::resource('instituciones', \App\Http\Controllers\Admin\InstitucionController::class)->except(['show'])->parameters(['instituciones' => 'institucion']);
    
    // Ubicación Electoral - CRUD en cascada
    Route::prefix('ubicacion')->name('ubicacion.')->group(function () {
        Route::resource('departamentos', \App\Http\Controllers\Admin\Ubicacion\DepartamentoController::class);
        Route::resource('provincias', \App\Http\Controllers\Admin\Ubicacion\ProvinciaController::class);
        Route::resource('municipios', \App\Http\Controllers\Admin\Ubicacion\MunicipioController::class);
        Route::resource('asientos', \App\Http\Controllers\Admin\Ubicacion\AsientoController::class);
        Route::resource('recintos', \App\Http\Controllers\Admin\Ubicacion\RecintoController::class);
        Route::resource('mesas', \App\Http\Controllers\Admin\Ubicacion\MesaController::class);
    });
    
    // Gestión de roles
    Route::get('/jurados', [\App\Http\Controllers\Admin\JuradoController::class, 'index'])->name('jurados.index');
    Route::post('/jurados/sorteo', [\App\Http\Controllers\Admin\JuradoController::class, 'sorteo'])->name('jurados.sorteo');
    Route::delete('/jurados/eliminar', [\App\Http\Controllers\Admin\JuradoController::class, 'eliminarSorteo'])->name('jurados.eliminar');
    Route::patch('/jurados/{jurado}/verificar', [\App\Http\Controllers\Admin\JuradoController::class, 'verificar'])->name('jurados.verificar');
    
    Route::get('/veedores', [\App\Http\Controllers\Admin\VeedorController::class, 'index'])->name('veedores.index');
    Route::post('/veedores/{veedor}/aprobar', [\App\Http\Controllers\Admin\VeedorController::class, 'aprobar'])->name('veedores.aprobar');
    Route::post('/veedores/{veedor}/rechazar', [\App\Http\Controllers\Admin\VeedorController::class, 'rechazar'])->name('veedores.rechazar');
    
    Route::resource('delegados', \App\Http\Controllers\Admin\DelegadoController::class)->except(['show', 'edit', 'update']);
    
    // Gestión de credenciales
    Route::get('/credenciales', [\App\Http\Controllers\Admin\CredencialController::class, 'index'])->name('credenciales.index');
    Route::get('/credenciales/generar/{persona}/{rol}', [\App\Http\Controllers\Admin\CredencialController::class, 'generar'])->name('credenciales.generar');
    Route::get('/credenciales/descargar/{id}', [\App\Http\Controllers\Admin\CredencialController::class, 'descargar'])->name('credenciales.descargar');
    Route::get('/credenciales/generar-todos/{rol}', [\App\Http\Controllers\Admin\CredencialController::class, 'generarTodas'])->name('credenciales.generar.todos');
});

// Voluntario - Consulta de roles
Route::get('/voluntario', [\App\Http\Controllers\VoluntarioController::class, 'index'])->name('voluntario.index');
Route::post('/voluntario/consultar', [\App\Http\Controllers\VoluntarioController::class, 'consultar'])->name('vol.consultar');

// Consultas específicas por rol
Route::get('/jurado', [\App\Http\Controllers\VoluntarioController::class, 'jurado'])->name('vol.jurado');
Route::get('/veedor', [\App\Http\Controllers\VoluntarioController::class, 'veedor'])->name('vol.veedor');
Route::get('/delegado', [\App\Http\Controllers\VoluntarioController::class, 'delegado'])->name('vol.delegado');

// Descarga de credenciales
Route::get('/voluntario/descargar-credencial', [\App\Http\Controllers\VoluntarioController::class, 'descargarCredencial'])->name('vol.descargar-credencial');

// Registro de veedores
Route::get('/veedor/registro', [\App\Http\Controllers\VeedorRegistroController::class, 'create'])->name('vol.veedor.create');
Route::post('/veedor/registro', [\App\Http\Controllers\VeedorRegistroController::class, 'store'])->name('vol.veedor.store');
Route::get('/voluntario/buscar-persona', [\App\Http\Controllers\VeedorRegistroController::class, 'buscarPersona'])->name('vol.buscar-persona');

// Academia Electoral
Route::get('/academia', [\App\Http\Controllers\Academia\AcademiaController::class, 'index'])->name('academia.index');
Route::post('/academia/consultar', [\App\Http\Controllers\Academia\AcademiaController::class, 'consultar'])->name('academia.consultar');
Route::get('/academia/capacitacion', [\App\Http\Controllers\Academia\AcademiaController::class, 'capacitacion'])->name('academia.capacitacion');
Route::get('/academia/nivel', [\App\Http\Controllers\Academia\AcademiaController::class, 'nivel'])->name('academia.nivel');
Route::post('/academia/completar-nivel', [\App\Http\Controllers\Academia\AcademiaController::class, 'completarNivel'])->name('academia.completar-nivel');
Route::get('/academia/quiz', [\App\Http\Controllers\Academia\AcademiaController::class, 'quiz'])->name('academia.quiz');
Route::post('/academia/evaluar-quiz', [\App\Http\Controllers\Academia\AcademiaController::class, 'evaluarQuiz'])->name('academia.evaluar-quiz');
