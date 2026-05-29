<template>
  <header class="header-exacto">
    
    <div class="header-logo-container">
      <RouterLink to="/">
        <img src="/contenido/logoParteArriba.png" alt="Logo Per L'Art" />
      </RouterLink>
    </div>

    <nav class="nav-links-clean" :class="{ 'is-open': isMenuOpen }">
      <RouterLink class="nav-link" to="/products" @click="isMenuOpen = false">
        Productes
      </RouterLink>
      
      <RouterLink class="nav-link" to="/sobre-nosaltres" @click="isMenuOpen = false">
        Sobre nosaltres
      </RouterLink>
      
      <RouterLink class="nav-link" to="/contacte" @click="isMenuOpen = false">
        Contacte
      </RouterLink>

      <template v-if="authStore.isAuthenticated">
        <RouterLink class="nav-link" to="/perfil" @click="isMenuOpen = false">
          {{ authStore.user?.name }}
        </RouterLink>

        <RouterLink 
          v-if="authStore.user?.role === 'admin'" 
          to="/admin/importar" 
          class="nav-link" 
          @click="isMenuOpen = false"
        >
          Importar Productes
        </RouterLink>

        <button @click="handleMenuLogout" class="nav-link logout-btn">
          Cerrar Sesión
        </button>
      </template>

      <template v-else>
        <RouterLink class="nav-link" to="/login" @click="isMenuOpen = false">
          Iniciar Sesión
        </RouterLink>
      </template>
      
      <RouterLink to="/cart" class="relative">
      Carrito
      <span v-if="totalItems > 0" class="absolute -top-2 -right-2 bg-red-500 text-xs rounded-full px-2">
        {{ totalItems }}
      </span>
    </RouterLink>
    </nav>

    <div class="header-right-side">
      <button class="menu-toggle-btn" @click="isMenuOpen = !isMenuOpen">
        <i class="fas fa-bars"></i> 
      </button>
    </div>
    
  </header>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/authStore";
import { useCartStore } from '../stores/cartStore';
import { storeToRefs } from 'pinia';

const cartStore = useCartStore();
const { totalItems } = storeToRefs(cartStore);
const authStore = useAuthStore();
const router = useRouter();

// Variable para controlar si el menú hamburguesa está abierto
const isMenuOpen = ref(false);

const handleLogout = async () => {
  await authStore.logout();
  router.push("/login");
};

// Pequeña función extra para cerrar el menú antes de hacer logout
const handleMenuLogout = async () => {
  isMenuOpen.value = false;
  await handleLogout();
};
</script>

<style scoped>
@import "../assets/css/common.css";
</style>