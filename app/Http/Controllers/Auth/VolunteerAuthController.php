<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Common\Persona;

class VolunteerAuthController extends Controller
{
    /**
     * Muestra la pantalla de consulta por CI para voluntarios
     */
    public function show()
    {
        return view('voluntario.index');
    }

    /**
     * Consulta la CI del voluntario y redirige según su rol
     */
    public function consultarCI(Request $request)
    {
        $request->validate(['ci' => 'required|numeric']);

        $persona = Persona::where('ci', $request->ci)->first();

        if (!$persona)
            return back()->with('mensaje', 'CI no válido, ingrese un CI válido.');

        if ($persona->estado === 'FALLECIDO')
            return back()->with('mensaje', 'Persona no apta para ningún rol (fallecida).');

        if ($persona->jurado)
            return redirect()->route('vol.jurado', $persona->id);
        if ($persona->veedor)
            return redirect()->route('vol.veedor', $persona->id);
        if ($persona->delegado)
            return redirect()->route('vol.delegado', $persona->id);

        return back()->with('mensaje', 'Usted no tiene ningún rol asignado.');
    }
}
