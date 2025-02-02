<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller {
    public function login(Request $request) {
        if (Auth::check()) {
            return response()->json(['message' => 'Ya has iniciado sesión'], 200);
        }

        $credentials = $request->only('email', 'password');
        Log::info('Intentando iniciar sesión con credenciales:', $credentials);
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        }
        
        Log::warning('Inicio de sesión fallido para el usuario:', ['email' => $request->input('email')]);
        return response()->json(['message' => 'No autorizado'], 401);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Cierre de sesión exitoso']);
    }

    public function user(Request $request) {
        return response()->json($request->user());
    }

    public function protectedRoute(Request $request) {
        return response()->json(['message' => 'Esta es una ruta protegida', 'user' => $request->user()]);
    }
}
