<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class VerifyCaptcha
{
    public function handle(Request $request, Closure $next)
    {
        //Verificar si la solicitud incluye un token de reCAPTCHA
        if ($request->has('g-recaptcha-response')) {
            $captcha = $request->input('g-recaptcha-response');
            
            //Verificar si el token es válido
            if (!NoCaptcha::verifyResponse($captcha)) {
                return response()->json([
                    'message' => 'Error de validación de reCAPTCHA'
                ], 422);
            }
        } else {
            return response()->json([
                'message' => 'El reCAPTCHA es obligatorio'
            ], 422);
        }

        return $next($request);
    }
}