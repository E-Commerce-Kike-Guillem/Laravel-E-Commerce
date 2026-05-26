<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>

<template>
  <nav class="mi-navbar">
    <RouterLink to="/">Inicio</RouterLink>
    <RouterLink to="/products">Productos</RouterLink>

    <template v-if="authStore.isAuthenticated">
      <span class="user-greeting">Hola, {{ authStore.user.name }}</span>
      <button @click="handleLogout">Sortir</button>
    </template>
    <template v-else>
      <RouterLink to="/login">Login</RouterLink>
    </template>
  </nav>
</template>

<style scoped>
.mi-navbar {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background-color: #f3f4f6;
  border-bottom: 1px solid #e5e7eb;
}
</style>