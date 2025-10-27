<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Credencial;
use App\Models\Common\Persona;
use App\Services\CredencialService;
use Illuminate\Http\Request;

class CredencialController extends Controller
{
    public function index()
    {
        $credenciales = Credencial::with('persona')->orderBy('emitido_en', 'desc')->get();
        
        // Obtener estadísticas por rol
        $stats = [
            'jurados' => Credencial::porRol('JURADO')->count(),
            'veedores' => Credencial::porRol('VEEDOR')->count(),
            'delegados' => Credencial::porRol('DELEGADO')->count(),
            'total' => Credencial::count()
        ];
        
        return view('admin.credenciales.index', compact('credenciales', 'stats'));
    }

    public function generar($persona_id, $rol, CredencialService $service)
    {
        $persona = Persona::findOrFail($persona_id);
        $service->generar($persona, $rol);
        return back()->with('ok', 'Credencial generada correctamente.');
    }

    public function descargar($id)
    {
        $credencial = Credencial::findOrFail($id);
        return response()->download(public_path($credencial->pdf_path));
    }

    public function generarTodas($rol)
    {
        try {
            // Obtener personas según el rol
            $personas = collect();
            
            if ($rol === 'JURADO') {
                $personas = Persona::whereHas('jurado')->get();
            } elseif ($rol === 'VEEDOR') {
                $personas = Persona::whereHas('veedor')->get();
            } elseif ($rol === 'DELEGADO') {
                $personas = Persona::whereHas('delegado')->get();
            }
            
            $generadas = 0;
            
            // Crear instancia del servicio
            $service = new \App\Services\CredencialService();
            
            foreach ($personas as $persona) {
                // Verificar si ya existe credencial para esta persona y rol
                $existe = Credencial::where('id_persona', $persona->id_persona)
                    ->where('rol', $rol)
                    ->exists();
                    
                if (!$existe) {
                    $service->generar($persona, $rol);
                    $generadas++;
                }
            }
            
            return back()->with('ok', "Se generaron {$generadas} credenciales de {$rol} correctamente.");
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar credenciales: ' . $e->getMessage());
        }
    }
}
