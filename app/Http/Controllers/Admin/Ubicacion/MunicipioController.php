<?php

namespace App\Http\Controllers\Admin\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Municipio;
use App\Models\Ubicacion\Provincia;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function index()
    {
        $municipios = Municipio::with('provincia.departamento')->get();
        return view('admin.ubicacion.municipios.index', compact('municipios'));
    }

    public function create()
    {
        $provincias = Provincia::with('departamento')->get();
        return view('admin.ubicacion.municipios.create', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_provincia' => 'required|exists:provincias,id_provincia',
        ]);

        Municipio::create($request->only('nombre', 'id_provincia'));
        return redirect()->route('admin.ubicacion.municipios.index')->with('ok', 'Municipio creado correctamente.');
    }

    public function show(Municipio $municipio)
    {
        $municipio->load('provincia.departamento', 'asientos.recintos.mesas');
        return view('admin.ubicacion.municipios.show', compact('municipio'));
    }

    public function edit(Municipio $municipio)
    {
        $provincias = Provincia::with('departamento')->get();
        return view('admin.ubicacion.municipios.edit', compact('municipio', 'provincias'));
    }

    public function update(Request $request, Municipio $municipio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_provincia' => 'required|exists:provincias,id_provincia',
        ]);

        $municipio->update($request->only('nombre', 'id_provincia'));
        return redirect()->route('admin.ubicacion.municipios.index')->with('ok', 'Municipio actualizado correctamente.');
    }

    public function destroy(Municipio $municipio)
    {
        if ($municipio->asientos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el municipio porque tiene asientos asociados.');
        }
        
        $municipio->delete();
        return back()->with('ok', 'Municipio eliminado correctamente.');
    }
}
