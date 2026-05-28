<template>
  <div class="layout-principal">
    
    <div class="navbar-wrapper">
      <Navbar />
    </div>
    
    <main class="page-content">
      <RouterView />
    </main>
    
    <Footer />

  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue' // <-- Importem el nou component
import { onMounted } from 'vue';
import { useAuthStore } from './stores/authStore';

const authStore = useAuthStore();

onMounted(async () => {
  // Cuando la app carga, preguntamos al backend si hay una sesión activa
  await authStore.fetchUser(); 
});
</script>

<style>
/* Reseteamos el margen que traen los navegadores por defecto */
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
}

/* Forzamos que la app sea una columna de arriba a abajo */
#app, .layout-principal {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* 100% del alto de la ventana */
}

/* Contenedor de la navbar: se queda pegado arriba sí o sí */
.navbar-wrapper {
  position: sticky;
  top: 0;
  z-index: 9999;
  width: 100%;
  background-color: white; 
  box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* Sombra para que se diferencie del fondo */
}

/* El contenido crece para llenar el resto de la pantalla */
.page-content {
  flex-grow: 1; 
  display: flex; 
  flex-direction: column;
  /* padding: 2rem; <-- BORRA ESTA LÍNEA */
}</style>