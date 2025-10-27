<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Veedores\Veedor;
use Illuminate\Http\Request;

class VeedorController extends Controller
{
    public function index()
    {
        $veedores = Veedor::with(['persona', 'institucion'])->orderBy('id_veedor','desc')->get();
        return view('admin.veedores.index', compact('veedores'));
    }

    public function aprobar(Veedor $veedor)
    {
        $veedor->update(['estado' => 'APROBADO', 'motivo_rechazo' => null]);
        return back()->with('ok','Solicitud aprobada.');
    }

    public function rechazar(Request $request, Veedor $veedor)
    {
        $request->validate(['motivo_rechazo' => 'required|min:5']);
        $veedor->update(['estado' => 'RECHAZADO', 'motivo_rechazo' => $request->motivo_rechazo]);
        return back()->with('ok','Solicitud rechazada con motivo.');
    }
}
