<template>
  <div class="login-container">
    <h2>Iniciar Sessió</h2>
    <form @submit.prevent="handleLogin">
      <div>
        <label>Email:</label>
        <input type="email" v-model="form.email" required />
      </div>
      <div>
        <label>Contrasenya:</label>
        <input type="password" v-model="form.password" required />
      </div>
      <button type="submit" :disabled="loading">
        {{ loading ? 'Carregant...' : 'Entrar' }}
      </button>
      <p v-if="errorMsg" class="error">{{ errorMsg }}</p>
    </form>
    <RouterLink to="/register">Registrar-se</RouterLink>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

const form = ref({ email: '', password: '' });
const errorMsg = ref('');
const loading = ref(false);

const authStore = useAuthStore();
const router = useRouter();

const handleLogin = async () => {
  loading.value = true;
  errorMsg.value = '';
  
  try {
    await authStore.login(form.value);
    router.push('/products'); // Redirige tras entrar
  } catch (error) {
    errorMsg.value = 'Credencials incorrectes o error de connexió.';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.error { color: red; }
/* Añade aquí tus estilos del login antiguo */
</style>