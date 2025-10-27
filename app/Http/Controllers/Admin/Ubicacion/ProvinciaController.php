<?php

namespace App\Http\Controllers\Admin\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Provincia;
use App\Models\Ubicacion\Departamento;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    public function index()
    {
        $provincias = Provincia::with('departamento')->get();
        return view('admin.ubicacion.provincias.index', compact('provincias'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('admin.ubicacion.provincias.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_departamento' => 'required|exists:departamentos,id_departamento',
        ]);

        Provincia::create($request->only('nombre', 'id_departamento'));
        return redirect()->route('admin.ubicacion.provincias.index')->with('ok', 'Provincia creada correctamente.');
    }

    public function show(Provincia $provincia)
    {
        $provincia->load('departamento', 'municipios.asientos.recintos.mesas');
        return view('admin.ubicacion.provincias.show', compact('provincia'));
    }

    public function edit(Provincia $provincia)
    {
        $departamentos = Departamento::all();
        return view('admin.ubicacion.provincias.edit', compact('provincia', 'departamentos'));
    }

    public function update(Request $request, Provincia $provincia)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_departamento' => 'required|exists:departamentos,id_departamento',
        ]);

        $provincia->update($request->only('nombre', 'id_departamento'));
        return redirect()->route('admin.ubicacion.provincias.index')->with('ok', 'Provincia actualizada correctamente.');
    }

    public function destroy(Provincia $provincia)
    {
        if ($provincia->municipios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la provincia porque tiene municipios asociados.');
        }
        
        $provincia->delete();
        return back()->with('ok', 'Provincia eliminada correctamente.');
    }
}
