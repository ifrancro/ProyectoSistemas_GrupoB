<?php

namespace App\Http\Controllers\Delegados;

use App\Http\Controllers\Controller;
use App\Models\Common\Persona;
use App\Models\Delegados\Delegado;
use Illuminate\Http\Request;

class DelegadoController extends Controller
{
    /**
     * Muestra el formulario de consulta para delegados
     */
    public function index()
    {
        return view('delegados.index');
    }

    /**
     * Procesa la consulta de CI para delegados
     */
    public function consultar(Request $request)
    {
        $request->validate([
            'ci' => 'required|numeric'
        ]);

        $persona = Persona::where('ci', $request->ci)->first();

        if (!$persona) {
            return back()->with('mensaje', 'CI no válido.');
        }

        if (!$persona->delegado) {
            return back()->with('mensaje', 'Usted no es delegado.');
        }

        $delegado = $persona->delegado;

        return view('delegados.resultado', compact('persona', 'delegado'));
    }

    /**
     * Muestra los detalles del delegado (para el flujo de voluntarios)
     */
    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        
        if (!$persona->delegado) {
            return redirect()->route('vol.login')->with('mensaje', 'Usted no es delegado.');
        }

        $delegado = $persona->delegado;

        return view('delegados.show', compact('persona', 'delegado'));
    }
}