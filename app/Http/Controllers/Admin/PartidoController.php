<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delegados\Partido;
use Illuminate\Support\Facades\Storage;

class PartidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partidos = Partido::all();
        return view('admin.partidos.index', compact('partidos'));
    }

    public function create()
    {
        return view('admin.partidos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sigla' => 'required|unique:partidos,sigla',
            'nombre' => 'required',
            'estado' => 'required|in:ACTIVO,INACTIVO',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('sigla','nombre','estado');
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partidos/logos', 'public');
            $data['logo_url'] = 'storage/' . $path;
        }

        Partido::create($data);
        return redirect()->route('admin.partidos.index')->with('ok','Partido registrado.');
    }

    public function show(Partido $partido)
    {
        return view('admin.partidos.show', compact('partido'));
    }

    public function edit(Partido $partido)
    {
        return view('admin.partidos.edit', compact('partido'));
    }

    public function update(Request $request, Partido $partido)
    {
        $request->validate([
            'sigla' => 'required|unique:partidos,sigla,'.$partido->id_partido.',id_partido',
            'nombre' => 'required',
            'estado' => 'required|in:ACTIVO,INACTIVO',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('sigla','nombre','estado');
        
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($partido->logo_url && Storage::disk('public')->exists(str_replace('storage/', '', $partido->logo_url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $partido->logo_url));
            }
            
            $path = $request->file('logo')->store('partidos/logos', 'public');
            $data['logo_url'] = 'storage/' . $path;
        }

        $partido->update($data);
        return redirect()->route('admin.partidos.index')->with('ok','Partido actualizado.');
    }

    public function destroy(Partido $partido)
    {
        // Eliminar logo si existe
        if ($partido->logo_url && Storage::disk('public')->exists(str_replace('storage/', '', $partido->logo_url))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $partido->logo_url));
        }
        
        $partido->delete();
        return back()->with('ok','Partido eliminado.');
    }
}
