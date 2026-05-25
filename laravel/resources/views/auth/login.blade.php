
    @vite(['resources/css/stylesAuth.css'])

    <div class="auth-container">
        <div class="auth-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/contenido/logoParteArriba.png') }}" alt="Logo Per L'Art">
            </a>
        </div>

        <h2>Benvingut de nou</h2>
        <p class="subtitle">Introdueix les teves credencials per accedir</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Ex: usuari@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password">Contrasenya</label>
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>


            <button type="submit" class="btn-auth">Entrar</button>
        </form>

        <div class="auth-footer">
            <p>No tens compte? <a href="{{ route('register') }}">Registra't aquí</a></p>
            
            @if (Route::has('password.request'))
                <p style="margin-top: 10px;">
                    <a href="{{ route('password.request') }}">He oblidat la contrasenya</a>
                </p>
            @endif

            <p style="margin-top: 10px;"><a href="{{ route('home') }}">Tornar a la botiga</a></p>
        </div>
    </div>
