<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Muestra la página de inicio con opciones de acceso
     */
    public function index()
    {
        return view('landing');
    }
}
