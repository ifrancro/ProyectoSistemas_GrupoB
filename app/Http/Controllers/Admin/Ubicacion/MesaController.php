<?php

namespace App\Http\Controllers\Admin\Ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion\Mesa;
use App\Models\Ubicacion\Recinto;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::with('recinto.asiento.municipio.provincia.departamento')->get();
        return view('admin.ubicacion.mesas.index', compact('mesas'));
    }

    public function create()
    {
        $recintos = Recinto::with('asiento.municipio.provincia.departamento')->get();
        return view('admin.ubicacion.mesas.create', compact('recintos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|min:1',
            'id_recinto' => 'required|exists:recintos,id_recinto',
        ]);

        // Verificar que el número de mesa sea único en el recinto
        $existeMesa = Mesa::where('id_recinto', $request->id_recinto)
                         ->where('numero', $request->numero)
                         ->exists();

        if ($existeMesa) {
            return back()->withErrors(['numero' => 'Ya existe una mesa con este número en el recinto seleccionado.']);
        }

        Mesa::create($request->only('numero', 'id_recinto'));
        return redirect()->route('admin.ubicacion.mesas.index')->with('ok', 'Mesa creada correctamente.');
    }

    public function show(Mesa $mesa)
    {
        $mesa->load('recinto.asiento.municipio.provincia.departamento', 'jurados.persona', 'delegados.persona');
        return view('admin.ubicacion.mesas.show', compact('mesa'));
    }

    public function edit(Mesa $mesa)
    {
        $recintos = Recinto::with('asiento.municipio.provincia.departamento')->get();
        return view('admin.ubicacion.mesas.edit', compact('mesa', 'recintos'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'numero' => 'required|integer|min:1',
            'id_recinto' => 'required|exists:recintos,id_recinto',
        ]);

        // Verificar que el número de mesa sea único en el recinto (excluyendo la mesa actual)
        $existeMesa = Mesa::where('id_recinto', $request->id_recinto)
                         ->where('numero', $request->numero)
                         ->where('id_mesa', '!=', $mesa->id_mesa)
                         ->exists();

        if ($existeMesa) {
            return back()->withErrors(['numero' => 'Ya existe una mesa con este número en el recinto seleccionado.']);
        }

        $mesa->update($request->only('numero', 'id_recinto'));
        return redirect()->route('admin.ubicacion.mesas.index')->with('ok', 'Mesa actualizada correctamente.');
    }

    public function destroy(Mesa $mesa)
    {
        if ($mesa->jurados()->count() > 0 || $mesa->delegados()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la mesa porque tiene jurados o delegados asignados.');
        }
        
        $mesa->delete();
        return back()->with('ok', 'Mesa eliminada correctamente.');
    }
}
