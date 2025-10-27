<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\Persona;
use App\Models\Veedores\Veedor;
use App\Models\Delegados\Delegado;
use App\Models\Jurados\Jurado;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal del administrador
     */
    public function index()
    {
        $stats = [
            'personas'  => Persona::count(),
            'veedores'  => Veedor::count(),
            'delegados' => Delegado::count(),
            'jurados'   => Jurado::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
