<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Common\Persona;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::orderBy('apellido')->paginate(10);
        return view('admin.personas.index', compact('personas'));
    }

    public function create()
    {
        return view('admin.personas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|numeric|unique:personas,ci',
            'nombre' => 'required|regex:/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/',
            'apellido' => 'required|regex:/^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]+$/',
            'fecha_nacimiento' => 'nullable|date',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100',
            'estado' => 'required|in:VIVO,FALLECIDO',
            'foto_carnet' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_carnet');
        
        if ($request->hasFile('foto_carnet')) {
            $path = $request->file('foto_carnet')->store('personas/fotos', 'public');
            $data['foto_carnet'] = 'storage/' . $path;
        }

        Persona::create($data);
        return redirect()->route('admin.personas.index')->with('ok', 'Persona registrada correctamente.');
    }

    public function show(Persona $persona)
    {
        return view('admin.personas.show', compact('persona'));
    }

    public function edit(Persona $persona)
    {
        return view('admin.personas.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'nullable|date',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100',
            'estado' => 'required|in:VIVO,FALLECIDO',
            'foto_carnet' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_carnet');
        
        if ($request->hasFile('foto_carnet')) {
            $path = $request->file('foto_carnet')->store('personas/fotos', 'public');
            $data['foto_carnet'] = 'storage/' . $path;
        }

        $persona->update($data);
        return redirect()->route('admin.personas.index')->with('ok', 'Datos actualizados.');
    }

    public function destroy(Persona $persona)
    {
        if ($persona->jurado || $persona->veedor || $persona->delegado) {
            return back()->with('error', 'No se puede eliminar: la persona tiene un rol asignado.');
        }
        $persona->delete();
        return back()->with('ok', 'Persona eliminada.');
    }
}
