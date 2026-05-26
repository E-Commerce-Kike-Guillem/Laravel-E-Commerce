<template>
  <div class="register-container">
    <h2>Crear un Compte</h2>
    
    <form @submit.prevent="handleRegister">
      <div>
        <label>Nom:</label>
        <input type="text" v-model="form.name" required />
      </div>
      
      <div>
        <label>Email:</label>
        <input type="email" v-model="form.email" required />
      </div>
      
      <div>
        <label>Contrasenya:</label>
        <input type="password" v-model="form.password" required />
      </div>
      
      <div>
        <label>Confirmar Contrasenya:</label>
        <input type="password" v-model="form.password_confirmation" required />
      </div>
      
      <button type="submit" :disabled="loading">
        {{ loading ? 'Creant compte...' : 'Registrar-se' }}
      </button>
      
      <ul v-if="Object.keys(errors).length > 0" class="error-list">
        <li v-for="(errorArray, field) in errors" :key="field">
          {{ errorArray[0] }}
        </li>
      </ul>
    </form>
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
    router.push('/products'); // Redirigimos al catálogo tras registrarnos
  } catch (error) {
    // Si Laravel devuelve un error de validación (Status 422)
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
.register-container {
  max-width: 400px;
  margin: 2rem auto;
  padding: 2rem;
  border: 1px solid #ddd;
  border-radius: 8px;
}
div {
  margin-bottom: 1rem;
}
label {
  display: block;
  margin-bottom: 0.5rem;
}
input {
  width: 100%;
  padding: 0.5rem;
}
.error-list {
  color: red;
  margin-top: 1rem;
  padding-left: 1.5rem;
}
</style>