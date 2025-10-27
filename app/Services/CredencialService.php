<?php

namespace App\Services;

use App\Models\Common\Credencial;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CredencialService
{
    public function generar($persona, $rol)
    {
        try {
            // Generar PDF 
            $pdf = Pdf::loadView('pdf.credencial', compact('persona', 'rol'));
            $filename = 'credenciales/' . $rol . '_' . $persona->ci . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            // Crear registro en base de datos
            $credencial = Credencial::create([
                'id_persona' => $persona->id_persona,
                'rol' => $rol,
                'qr_code' => null, // Sin QR Code
                'pdf_path' => 'storage/' . $filename,
                'emitido_en' => now()
            ]);
            
            Log::info("Credencial generada exitosamente para {$persona->ci} como {$rol} (sin QR)");
            return $credencial;
            
        } catch (\Exception $e) {
            Log::error('Error generando credencial: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }
}