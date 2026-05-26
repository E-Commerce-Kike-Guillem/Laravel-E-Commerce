<template>
  <div class="auth-wrapper">
  <div class="auth-container">
    
    <div class="auth-logo">
      <RouterLink to="/">
        <img src="/contenido/logoParteArriba.png" alt="Logo Per L'Art">
      </RouterLink>
    </div>

    <h2>Benvingut de nou</h2>
    <p class="subtitle">Introdueix les teves credencials per accedir</p>

    <div v-if="errorMsg" class="error-alert">
      {{ errorMsg }}
    </div>

    <form @submit.prevent="handleLogin">
      
      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          v-model="form.email" 
          required 
          autofocus 
          placeholder="Ex: usuari@email.com"
        >
      </div>

      <div class="form-group">
        <label for="password">Contrasenya</label>
        <input 
          type="password" 
          id="password" 
          v-model="form.password" 
          required 
          placeholder="••••••••"
        >
      </div>

      <button type="submit" class="btn-auth" :disabled="loading">
        {{ loading ? 'Carregant...' : 'Entrar' }}
      </button>

    </form>

    <div class="auth-footer">
      <p>No tens compte? <RouterLink to="/register">Registra't aquí</RouterLink></p>

      <p style="margin-top: 10px;">
        <RouterLink to="/">Tornar a la botiga</RouterLink>
      </p>
    </div>

  </div>
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
    router.push('/products'); 
  } catch (error) {
    errorMsg.value = 'Credencials incorrectes o error de connexió.';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* 1. Importem el teu CSS original */
@import '../assets/css/stylesAuth.css';

.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 70px); /* Restem l'alçada de la navbar aprox */
  width: 100%;
  background-color: #f9fafb; /* Color de fons suau, canvia'l si el teu era un altre */
}

/* 2. Afegim un estil extra per al missatge d'error de Vue (equivalent al x-input-error antic) */
.error-alert {
  color: #721c24;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
  text-align: center;
  font-size: 0.9rem;
}
</style>