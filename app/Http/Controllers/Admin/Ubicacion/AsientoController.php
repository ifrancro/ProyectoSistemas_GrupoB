<?php

namespace App\Http\Controllers\Admin\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Asiento;
use App\Models\Ubicacion\Municipio;
use Illuminate\Http\Request;

class AsientoController extends Controller
{
    public function index()
    {
        $asientos = Asiento::with('municipio.provincia.departamento')->get();
        return view('admin.ubicacion.asientos.index', compact('asientos'));
    }

    public function create()
    {
        $municipios = Municipio::with('provincia.departamento')->get();
        return view('admin.ubicacion.asientos.create', compact('municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_municipio' => 'required|exists:municipios,id_municipio',
        ]);

        Asiento::create($request->only('nombre', 'id_municipio'));
        return redirect()->route('admin.ubicacion.asientos.index')->with('ok', 'Asiento creado correctamente.');
    }

    public function show(Asiento $asiento)
    {
        $asiento->load('municipio.provincia.departamento', 'recintos.mesas');
        return view('admin.ubicacion.asientos.show', compact('asiento'));
    }

    public function edit(Asiento $asiento)
    {
        $municipios = Municipio::with('provincia.departamento')->get();
        return view('admin.ubicacion.asientos.edit', compact('asiento', 'municipios'));
    }

    public function update(Request $request, Asiento $asiento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_municipio' => 'required|exists:municipios,id_municipio',
        ]);

        $asiento->update($request->only('nombre', 'id_municipio'));
        return redirect()->route('admin.ubicacion.asientos.index')->with('ok', 'Asiento actualizado correctamente.');
    }

    public function destroy(Asiento $asiento)
    {
        if ($asiento->recintos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el asiento porque tiene recintos asociados.');
        }
        
        $asiento->delete();
        return back()->with('ok', 'Asiento eliminado correctamente.');
    }
}
