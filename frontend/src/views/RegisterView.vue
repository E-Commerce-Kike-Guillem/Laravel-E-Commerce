<template>
  <div class="auth-wrapper">
    <div class="auth-container">
      
      <div class="auth-logo">
        <RouterLink to="/">
          <img src="/contenido/logoParteArriba.png" alt="Logo Per L'Art">
        </RouterLink>
      </div>

      <h2>Crear Compte</h2>
      <p class="subtitle">Uneix-te a la nostra comunitat</p>

      <form @submit.prevent="handleRegister">
        
        <div class="form-group">
          <label for="name">Nom *</label>
          <input type="text" id="name" v-model="form.name" required autofocus>
          <span v-if="errors.name" class="error-msg">{{ errors.name[0] }}</span>
        </div>

        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" v-model="form.email" required>
          <span v-if="errors.email" class="error-msg">{{ errors.email[0] }}</span>
        </div>

        <div class="form-group">
          <label for="password">Contrasenya *</label>
          <input type="password" id="password" v-model="form.password" required>
          <span v-if="errors.password" class="error-msg">{{ errors.password[0] }}</span>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar contrasenya *</label>
          <input type="password" id="password_confirmation" v-model="form.password_confirmation" required>
        </div>

        <button type="submit" class="btn-auth" :disabled="loading">
          {{ loading ? 'Registrant...' : 'Registrar-se' }}
        </button>

      </form>

      <div class="auth-footer">
        <p>Ja tens compte? <RouterLink to="/login">Inicia sessió</RouterLink></p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const errors = ref({});
const loading = ref(false);

const authStore = useAuthStore();
const router = useRouter();

const handleRegister = async () => {
  loading.value = true;
  errors.value = {};
  
  try {
    await authStore.register(form.value);
    router.push('/products');
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      errors.value = { general: ['S\'ha produït un error inesperat.'] };
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
@import '../assets/css/stylesAuth.css';

.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 140px); 
  width: 100%;
  background-color: #f9fafb;
  padding: 2.5rem 1rem; 
  box-sizing: border-box; 
}

.error-msg {
  color: #dc3545;
  font-size: 0.8rem;
  margin-top: 5px;
  display: block;
}

.auth-logo {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin-bottom: 1.5rem;
}

.auth-logo img {
  display: block;
  margin: 0 auto;
  max-height: 70px; 
  width: auto;
}
</style>