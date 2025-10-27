<?php

namespace App\Http\Controllers\Admin\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::with('provincias')->get();
        return view('admin.ubicacion.departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('admin.ubicacion.departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos,nombre',
        ]);

        Departamento::create($request->only('nombre'));
        return redirect()->route('admin.ubicacion.departamentos.index')->with('ok', 'Departamento creado correctamente.');
    }

    public function show(Departamento $departamento)
    {
        $departamento->load('provincias.municipios.asientos.recintos.mesas');
        return view('admin.ubicacion.departamentos.show', compact('departamento'));
    }

    public function edit(Departamento $departamento)
    {
        return view('admin.ubicacion.departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos,nombre,' . $departamento->id_departamento . ',id_departamento',
        ]);

        $departamento->update($request->only('nombre'));
        return redirect()->route('admin.ubicacion.departamentos.index')->with('ok', 'Departamento actualizado correctamente.');
    }

    public function destroy(Departamento $departamento)
    {
        if ($departamento->provincias()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el departamento porque tiene provincias asociadas.');
        }
        
        $departamento->delete();
        return back()->with('ok', 'Departamento eliminado correctamente.');
    }
}
