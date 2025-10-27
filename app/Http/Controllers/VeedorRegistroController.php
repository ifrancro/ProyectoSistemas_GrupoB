<?php

namespace App\Http\Controllers;

use App\Models\Common\Persona;
use App\Models\Veedores\Veedor;
use App\Models\Veedores\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VeedorRegistroController extends Controller
{
    public function create()
    {
        $instituciones = Institucion::all();
        return view('voluntario.veedor-registro', compact('instituciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|min:5|max:15',
            'institucion_id' => 'required|exists:instituciones,id_institucion',
            'carta_respaldo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto_carnet' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Buscar la persona por CI
        $persona = Persona::where('ci', $request->ci)->first();
        if (!$persona) {
            return back()->with('error', 'CI no válido. Debe estar registrado en el sistema.');
        }

        // Verificar si ya es veedor
        $veedorExistente = Veedor::where('id_persona', $persona->id_persona)->first();
        if ($veedorExistente) {
            return back()->with('error', 'Ya tiene una solicitud de veedor registrada.');
        }

        // Verificar si ya tiene otro rol
        if ($persona->jurado || $persona->delegado) {
            return back()->with('error', 'Ya tiene otro rol asignado en el sistema.');
        }

        // Subir archivos
        $cartaPath = $request->file('carta_respaldo')->store('veedores/cartas', 'public');
        $fotoPath = $request->file('foto_carnet')->store('veedores/fotos', 'public');

        // Crear registro de veedor
        Veedor::create([
            'id_persona' => $persona->id_persona,
            'id_institucion' => $request->institucion_id,
            'carta_respaldo' => $cartaPath,
            'foto_carnet' => $fotoPath,
            'estado' => 'PENDIENTE',
            'motivo_rechazo' => null,
        ]);

        return redirect()->route('voluntario.index')
            ->with('mensaje', 'Solicitud de veedor enviada correctamente. Será revisada por el administrador.');
    }

    public function buscarPersona(Request $request)
    {
        $ci = $request->ci;
        $persona = Persona::where('ci', $ci)->first();

        if (!$persona) {
            return response()->json(['error' => 'CI no encontrado'], 404);
        }

        return response()->json([
            'nombre' => $persona->nombre,
            'apellido' => $persona->apellido,
            'ciudad' => $persona->ciudad,
            'fecha_nacimiento' => $persona->fecha_nacimiento,
            'estado' => $persona->estado,
        ]);
    }
}
