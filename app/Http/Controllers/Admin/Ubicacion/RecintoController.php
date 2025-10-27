<?php

namespace App\Http\Controllers\Admin\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Recinto;
use App\Models\Ubicacion\Asiento;
use Illuminate\Http\Request;

class RecintoController extends Controller
{
    public function index()
    {
        $recintos = Recinto::with('asiento.municipio.provincia.departamento')->get();
        return view('admin.ubicacion.recintos.index', compact('recintos'));
    }

    public function create()
    {
        $asientos = Asiento::with('municipio.provincia.departamento')->get();
        return view('admin.ubicacion.recintos.create', compact('asientos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'direccion' => 'nullable|string|max:200',
            'id_asiento' => 'required|exists:asientos,id_asiento',
        ]);

        Recinto::create($request->only('nombre', 'direccion', 'id_asiento'));
        return redirect()->route('admin.ubicacion.recintos.index')->with('ok', 'Recinto creado correctamente.');
    }

    public function show(Recinto $recinto)
    {
        $recinto->load('asiento.municipio.provincia.departamento', 'mesas');
        return view('admin.ubicacion.recintos.show', compact('recinto'));
    }

    public function edit(Recinto $recinto)
    {
        $asientos = Asiento::with('municipio.provincia.departamento')->get();
        return view('admin.ubicacion.recintos.edit', compact('recinto', 'asientos'));
    }

    public function update(Request $request, Recinto $recinto)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'direccion' => 'nullable|string|max:200',
            'id_asiento' => 'required|exists:asientos,id_asiento',
        ]);

        $recinto->update($request->only('nombre', 'direccion', 'id_asiento'));
        return redirect()->route('admin.ubicacion.recintos.index')->with('ok', 'Recinto actualizado correctamente.');
    }

    public function destroy(Recinto $recinto)
    {
        if ($recinto->mesas()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el recinto porque tiene mesas asociadas.');
        }
        
        $recinto->delete();
        return back()->with('ok', 'Recinto eliminado correctamente.');
    }
}
