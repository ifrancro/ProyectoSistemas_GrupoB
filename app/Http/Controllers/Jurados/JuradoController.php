<?php

namespace App\Http\Controllers\Jurados;

use App\Http\Controllers\Controller;
use App\Models\Common\Persona;
use App\Models\Jurados\Jurado;
use Illuminate\Http\Request;

class JuradoController extends Controller
{
    /**
     * Muestra el formulario de consulta para jurados
     */
    public function index()
    {
        return view('jurados.index');
    }

    /**
     * Procesa la consulta de CI para jurados
     */
    public function consultar(Request $request)
    {
        $request->validate([
            'ci' => 'required|numeric'
        ]);

        $persona = Persona::where('ci', $request->ci)->first();

        if (!$persona) {
            return back()->with('mensaje', 'CI no válido, ingrese un CI válido.');
        }

        if (!$persona->jurado) {
            return back()->with('mensaje', 'Usted no es jurado.');
        }

        $jurado = $persona->jurado;
        $mesa = $jurado->mesa;
        $recinto = $mesa->recinto;

        return view('jurados.resultado', compact('persona', 'jurado', 'mesa', 'recinto'));
    }

    /**
     * Muestra los detalles del jurado (para el flujo de voluntarios)
     */
    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        
        if (!$persona->jurado) {
            return redirect()->route('vol.login')->with('mensaje', 'Usted no es jurado.');
        }

        $jurado = $persona->jurado;
        $mesa = $jurado->mesa;
        $recinto = $mesa->recinto;

        return view('jurados.show', compact('persona', 'jurado', 'mesa', 'recinto'));
    }
}