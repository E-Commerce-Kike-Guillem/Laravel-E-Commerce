<template>
  <nav class="mi-navbar">
    <RouterLink to="/">Inicio</RouterLink>
    <RouterLink to="/products">Productos</RouterLink>
    
    <RouterLink to="/login" v-if="!isAuthenticated">Login</RouterLink>
    <button v-else @click="logout">Sortir</button>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

// Variable reactiva falsa para que la página cargue (luego usaremos Pinia)
const isAuthenticated = ref(false);

const logout = () => {
  isAuthenticated.value = false;
  console.log('Saliendo...');
};
</script>

<style scoped>
/* Un poco de CSS básico para que la navbar se vea decente */
.mi-navbar {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background-color: #f3f4f6;
  border-bottom: 1px solid #e5e7eb;
}
</style>