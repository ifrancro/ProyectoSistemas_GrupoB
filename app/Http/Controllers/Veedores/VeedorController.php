<?php

namespace App\Http\Controllers\Veedores;

use App\Http\Controllers\Controller;
use App\Models\Common\Persona;
use App\Models\Veedores\Veedor;
use App\Models\Veedores\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VeedorController extends Controller
{
    /**
     * Muestra el formulario de consulta para veedores
     */
    public function index()
    {
        return view('veedores.index');
    }

    /**
     * Procesa la consulta de CI para veedores
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

        if (!$persona->veedor) {
            return back()->with('mensaje', 'Usted no es veedor.');
        }

        $veedor = $persona->veedor;

        return view('veedores.resultado', compact('persona', 'veedor'));
    }

    /**
     * Muestra los detalles del veedor (para el flujo de voluntarios)
     */
    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        
        if (!$persona->veedor) {
            return redirect()->route('vol.login')->with('mensaje', 'Usted no es veedor.');
        }

        $veedor = $persona->veedor;

        return view('veedores.show', compact('persona', 'veedor'));
    }

    /**
     * Muestra el formulario de registro de veedores
     */
    public function create()
    {
        $instituciones = Institucion::all();
        return view('veedores.create', compact('instituciones'));
    }

    /**
     * Procesa el registro de veedores
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|numeric',
            'institucion_id' => 'required|exists:instituciones,id_institucion',
            'carta_respaldo' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'foto_carnet' => 'required|file|mimes:jpg,png|max:2048',
        ]);

        // Buscar o crear persona
        $persona = Persona::where('ci', $request->ci)->first();
        
        if (!$persona) {
            return back()->with('mensaje', 'CI no encontrado en el sistema. Contacte al administrador.');
        }

        // Verificar que no tenga otro rol
        if ($persona->jurado || $persona->delegado) {
            return back()->with('mensaje', 'Esta persona ya tiene otro rol asignado.');
        }

        // Subir archivos
        $cartaPath = $request->file('carta_respaldo')->store('veedores/cartas', 'public');
        $fotoPath = $request->file('foto_carnet')->store('veedores/fotos', 'public');

        // Crear veedor
        Veedor::create([
            'id_persona' => $persona->id_persona,
            'id_institucion' => $request->institucion_id,
            'carta_respaldo' => 'storage/' . $cartaPath,
            'foto_carnet' => 'storage/' . $fotoPath,
            'estado' => 'PENDIENTE'
        ]);

        return redirect()->route('veedores.index')->with('mensaje', 'Solicitud enviada correctamente. Será revisada por el administrador.');
    }
}