<?php

namespace App\Http\Controllers;

use App\Models\Common\Persona;
use App\Models\Jurados\Jurado;
use App\Models\Veedores\Veedor;
use App\Models\Delegados\Delegado;
use App\Models\Common\Credencial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoluntarioController extends Controller
{
    public function index()
    {
        return view('voluntario.index');
    }

    public function consultar(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|min:5|max:15'
        ]);

        $ci = $request->ci;
        $persona = Persona::where('ci', $ci)->first();

        if (!$persona) {
            return back()->with('mensaje', 'CI no válido, ingrese un CI válido.');
        }

        // Verificar si es jurado
        $jurado = Jurado::where('id_persona', $persona->id_persona)->first();
        if ($jurado) {
            return redirect()->route('vol.jurado', ['ci' => $ci]);
        }

        // Verificar si es veedor
        $veedor = Veedor::where('id_persona', $persona->id_persona)->first();
        if ($veedor) {
            return redirect()->route('vol.veedor', ['ci' => $ci]);
        }

        // Verificar si es delegado
        $delegado = Delegado::where('id_persona', $persona->id_persona)->first();
        if ($delegado) {
            return redirect()->route('vol.delegado', ['ci' => $ci]);
        }

        return back()->with('mensaje', 'Usted no tiene ningún rol asignado en el sistema electoral.');
    }

    public function jurado(Request $request)
    {
        $ci = $request->ci;
        $persona = Persona::where('ci', $ci)->first();

        if (!$persona) {
            return redirect()->route('voluntario.index')->with('mensaje', 'CI no válido.');
        }

        $jurado = Jurado::with(['mesa.recinto.asiento.municipio.provincia.departamento'])
            ->where('id_persona', $persona->id_persona)
            ->first();

        if (!$jurado) {
            return redirect()->route('voluntario.index')->with('mensaje', 'Usted no es jurado.');
        }

        return view('voluntario.jurado', compact('persona', 'jurado'));
    }

    public function veedor(Request $request)
    {
        $ci = $request->ci;
        $persona = Persona::where('ci', $ci)->first();

        if (!$persona) {
            return redirect()->route('voluntario.index')->with('mensaje', 'CI no válido.');
        }

        $veedor = Veedor::with(['institucion'])
            ->where('id_persona', $persona->id_persona)
            ->first();

        if (!$veedor) {
            return redirect()->route('voluntario.index')->with('mensaje', 'Usted no es veedor.');
        }

        return view('voluntario.veedor', compact('persona', 'veedor'));
    }

    public function delegado(Request $request)
    {
        $ci = $request->ci;
        $persona = Persona::where('ci', $ci)->first();

        if (!$persona) {
            return redirect()->route('voluntario.index')->with('mensaje', 'CI no válido.');
        }

        $delegado = Delegado::with(['partido', 'mesa.recinto.asiento.municipio.provincia.departamento'])
            ->where('id_persona', $persona->id_persona)
            ->first();

        if (!$delegado) {
            return redirect()->route('voluntario.index')->with('mensaje', 'Usted no es delegado.');
        }

        return view('voluntario.delegado', compact('persona', 'delegado'));
    }

    public function descargarCredencial(Request $request)
    {
        $ci = $request->ci;
        $rol = $request->rol;

        $persona = Persona::where('ci', $ci)->first();
        if (!$persona) {
            return redirect()->route('voluntario.index')->with('mensaje', 'CI no válido.');
        }

        $credencial = Credencial::where('id_persona', $persona->id_persona)
            ->where('rol', $rol)
            ->first();

        if (!$credencial || !$credencial->pdf_path) {
            return back()->with('mensaje', 'Credencial no disponible. Contacte al administrador.');
        }

        $filePath = public_path($credencial->pdf_path);
        if (!file_exists($filePath)) {
            return back()->with('mensaje', 'Archivo de credencial no encontrado.');
        }

        return response()->download($filePath);
    }
}
