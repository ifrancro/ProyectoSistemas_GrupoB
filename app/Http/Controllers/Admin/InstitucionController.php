<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Veedores\Institucion;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instituciones = Institucion::all();
        return view('admin.instituciones.index', compact('instituciones'));
    }

    public function create()
    {
        return view('admin.instituciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'sigla' => 'nullable|string|max:20',
        ]);

        $data = $request->only('nombre','sigla');
        Institucion::create($data);
        return redirect()->route('admin.instituciones.index')->with('ok','Institución registrada.');
    }

    public function show(Institucion $institucion)
    {
        return view('admin.instituciones.show', compact('institucion'));
    }

    public function edit(Institucion $institucion)
    {
        return view('admin.instituciones.edit', compact('institucion'));
    }

    public function update(Request $request, Institucion $institucion)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'sigla' => 'nullable|string|max:20',
        ]);

        $data = $request->only('nombre','sigla');
        $institucion->update($data);
        return redirect()->route('admin.instituciones.index')->with('ok','Institución actualizada.');
    }

    public function destroy(Institucion $institucion)
    {
        $institucion->delete();
        return back()->with('ok','Institución eliminada.');
    }
}
