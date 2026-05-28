<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(Auth::user());
        }

        return response()->json(['message' => 'Credencials invàlides'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sessió tancada']);
    }

    public function register(Request $request)
    {
        // 1. Validamos los datos entrantes
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // 2. Creamos el usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. (Opcional pero recomendado) Iniciamos sesión automáticamente
        Auth::login($user);
        $request->session()->regenerate();

        // 4. Devolvemos el usuario creado
        return response()->json($user, 201);
    }

    public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'password' => bcrypt(Str::random(16)), // Contraseña aleatoria
    ]);

    Auth::login($user);

    request()->session()->regenerate();

    // Redirige al frontend (Vue)
    return redirect('http://localhost:5174');
}
}