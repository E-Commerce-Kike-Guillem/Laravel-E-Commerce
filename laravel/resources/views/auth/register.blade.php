    @vite(['resources/css/stylesAuth.css'])

    <div class="auth-container">
        <div class="auth-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/contenido/logoParteArriba.png') }}" alt="Logo Per L'Art">
            </a>
        </div>

        <h2>Crear Compte</h2>
        <p class="subtitle">Uneix-te a la nostra comunitat</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nom *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password">Contrasenya *</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar contrasenya *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="btn-auth">Registrar-se</button>
        </form>

        <div class="auth-footer">
            <p>Ja tens compte? <a href="{{ route('login') }}">Inicia sessió</a></p>
        </div>
    </div>
