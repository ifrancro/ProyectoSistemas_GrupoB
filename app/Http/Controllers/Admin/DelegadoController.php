<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delegados\Delegado;
use App\Models\Delegados\Partido;
use App\Models\Common\Persona;
use App\Models\Ubicacion\Mesa;
use Illuminate\Http\Request;

class DelegadoController extends Controller
{
    public function index()
    {
        $delegados = Delegado::with(['persona','partido','mesa'])->get();
        return view('admin.delegados.index', compact('delegados'));
    }

    public function create()
    {
        $personas = Persona::whereDoesntHave('jurado')
            ->whereDoesntHave('veedor')
            ->whereDoesntHave('delegado')
            ->where('estado','VIVO')->get();

        $partidos = Partido::all();
        $mesas = Mesa::all();
        return view('admin.delegados.create', compact('personas','partidos','mesas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id_persona',
            'partido_id' => 'required|exists:partidos,id_partido',
            'mesa_id' => 'required|exists:mesas,id_mesa',
        ]);

        Delegado::create([
            'id_persona' => $request->persona_id,
            'id_partido' => $request->partido_id,
            'id_mesa' => $request->mesa_id,
            'habilitado' => true
        ]);
        return redirect()->route('admin.delegados.index')->with('ok','Delegado registrado correctamente.');
    }

    public function destroy(Delegado $delegado)
    {
        $delegado->delete();
        return back()->with('ok','Delegado eliminado.');
    }
}
