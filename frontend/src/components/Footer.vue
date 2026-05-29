<template>
  <footer class="main-footer">
    <div class="container footer-grid">
      
      <div class="footer-logo">
        <RouterLink to="/">
          <img src="/contenido/log_blanc.png" alt="Logo">
        </RouterLink>
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
        <RouterLink to="/sobre-nosaltres">Sobre nosaltres</RouterLink>
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
</template>

<style scoped>
@import '../assets/css/common.css';


</style>