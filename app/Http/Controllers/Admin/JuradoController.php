<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurados\Jurado;
use App\Models\Jurados\Asistencia;
use App\Models\Common\Persona;
use App\Models\Ubicacion\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JuradoController extends Controller
{
    public function index()
    {
        $jurados = Jurado::with(['persona', 'mesa.recinto.asiento.municipio.provincia.departamento'])->orderBy('id_mesa')->get();
        return view('admin.jurados.index', compact('jurados'));
    }

    // 🧩 Realizar sorteo
    public function sorteo()
    {
        DB::transaction(function() {
            // Obtener todas las mesas con sus ubicaciones
            $mesas = Mesa::with(['recinto.asiento.municipio.provincia.departamento'])->get();
            $roles = ['PRESIDENTE', 'SECRETARIO', 'VOCAL'];

            foreach ($mesas as $mesa) {
                // Obtener la ciudad de la mesa (usando el municipio como ciudad)
                $ciudadMesa = $mesa->recinto->asiento->municipio->nombre;
                
                // Buscar personas disponibles de la misma ciudad
                $personasDisponibles = Persona::whereDoesntHave('jurado')
                    ->whereDoesntHave('veedor')
                    ->whereDoesntHave('delegado')
                    ->where('estado', 'VIVO')
                    ->where('ciudad', $ciudadMesa)
                    ->inRandomOrder()
                    ->get();

                // Asignar roles a esta mesa
                foreach ($roles as $rol) {
                    if ($personasDisponibles->count() > 0) {
                        $persona = $personasDisponibles->shift(); // Tomar la primera persona disponible
                        
                        Jurado::create([
                            'id_persona' => $persona->id_persona,
                            'id_mesa' => $mesa->id_mesa,
                            'cargo' => $rol,
                            'verificado' => false
                        ]);
                    }
                }
            }
        });

        return back()->with('ok', 'Sorteo de jurados realizado correctamente.');
    }

    // 🧩 Eliminar sorteo
    public function eliminarSorteo()
    {
        DB::transaction(function () {
            // Primero, eliminar todas las asistencias, ya que referencian a jurados
            Asistencia::query()->delete();
            // Luego, eliminar todos los jurados
            Jurado::query()->delete();
        });
        
        return back()->with('ok', 'Sorteo y asistencias relacionadas eliminadas. Puede generarlo nuevamente.');
    }

    // 🧩 Verificar/Desverificar jurado
    public function verificar(Jurado $jurado)
    {
        $jurado->verificado = !$jurado->verificado;
        $jurado->save();
        
        $mensaje = $jurado->verificado ? 'Jurado verificado correctamente.' : 'Verificación removida.';
        return back()->with('ok', $mensaje);
    }
}
