<template>
  <main class="page-content-wrapper">
    <div class="container my-5">
      <h1 class="page-title mb-5">Hola, {{ authStore.user?.name }}</h1>
      
      <div class="profile-card p-4 border rounded-lg bg-white shadow-sm">
        <form @submit.prevent="updateProfile">
          <div class="mb-4">
            <label class="block font-semibold mb-2">Nom d'usuari</label>
            <input 
              v-model="form.name" 
              type="text" 
              class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#243020] outline-none" 
            />
          </div>

          <div class="mb-4">
            <label class="block font-semibold mb-2">Email</label>
            <input 
              v-model="form.email" 
              type="email" 
              class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#243020] outline-none" 
            />
          </div>

          <div class="mb-4">
            <label class="block font-semibold mb-2">Nova contrasenya</label>
            <input 
              v-model="form.password" 
              type="password" 
              placeholder="Deixa en blanc si no vols canviar-la"
              class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#243020] outline-none" 
            />
          </div>

          <button type="submit" class="btn-cart-icon w-full mt-4">
            Guardar canvis
          </button>
        </form>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import http from '../services/http';
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore();
const form = ref({ name: '', email: '', password: '' });

onMounted(async () => {
  // Aseguramos que los datos actuales se carguen en el form
  if (authStore.user) {
    form.value.name = authStore.user.name;
    form.value.email = authStore.user.email;
  }
});

const updateProfile = async () => {
  try {
    await http.get('/sanctum/csrf-cookie');
    await http.patch('/profile', form.value);
    
    // AQUÍ ESTÁ LA CLAVE: Actualiza el store localmente
    authStore.user.name = form.value.name;
    authStore.user.email = form.value.email;
    
    alert('Perfil actualitzat correctament!');
  } catch (error) {
    console.error("Error:", error);
  }
};
</script>

<style scoped>
/* Usamos las clases que ya tienes definidas en tus estilos globales */
.page-content-wrapper {
  width: 100%;
  padding: 2rem 0;
}

.profile-card {
  max-width: 500px;
  margin: 0 auto;
}

.btn-cart-icon {
  height: 45px;
  background-color: #243020;
  color: white;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s, transform 0.2s;
  border-radius: 8px;
}

.btn-cart-icon:hover {
  transform: scale(1.02);
  background-color: #3a4d34;
}
</style>