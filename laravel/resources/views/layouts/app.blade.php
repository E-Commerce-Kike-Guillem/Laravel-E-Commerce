<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Per L'Art - Joieria</title>
    
    @vite([
    'resources/css/app.css', 
    'resources/js/app.js',
    'resources/css/common.css',
    'resources/css/styleIndex.css'
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('/contenido/log_blanc.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <header class="header-exacto">
        <div class="header-logo-container">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/contenido/logoParteArriba.png') }}" alt="Logo">
            </a>
        </div>

        <div class="header-right-side">
            <nav class="nav-links-clean">
                <a class="nav-link" href="/productes">Productes</a>
                <a class="nav-link" href="{{ route('sobre-nosaltres') }}">Sobre nosaltres</a>
                <a class="nav-link" href="contacte.php">Contacte</a>
                @auth
@else
    <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
@endauth

@auth
    <a href="{{ route('profile.edit') }}" class="nav-link">Mi Perfil</a>
    
    

    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="nav-link">Cerrar Sesión</button>
    </form>
@endauth
        </div>
    </header>

    <main>
        @if (request()->is('/'))
        <section class="hero">
            <div class="hero-content">
                <h1>Descobreix Peces Úniques</h1>
                <p>La nostra nova col·lecció inspirada en la cultura popular.</p>
                <a href="storage/products/hero.jpg" class="btn btn-primary">Explora la Col·lecció</a>
            </div>
            <div class="hero-background-image"></div>
        </section>
        @endif

        <section class="featured-products">
            @if (request()->is('/'))
            <h2>Novetats</h2>
            @else
            <h2>Descobreix la nostra gama de productes</h2>
            @endif
    <div class="container">
        {{ $slot }}
    </div>
</section>
</main>
    <footer class="main-footer">
        <div class="container footer-grid">
            
            <div class="footer-logo">
                <a href="{{ route('home') }}"><img src="./contenido/log_blanc.png" alt="Logo" lin></a>
            </div>
            
            <div class="footer-column">
                <h4>Informació</h4>
                <a href="#">Informació legal</a>
                <a href="#">Política de devolucions</a>
                <a href="#">Política de cookies</a>
            </div>
            
            <div class="footer-column">
                <h4>Contacte</h4>
                <p>Telèfon: 122 884 2887</p>
                <a href="#">Sobre nosaltres</a>
            </div>
            
            <div class="footer-column">
                <h4>Segueix-nos</h4>
                <div class="social-icons">
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>