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

      <div v-if="errorMsg" class="error-alert">
        {{ errorMsg }}
      </div>

      <form @submit.prevent="handleRegister" novalidate>
        
        <div class="form-group">
          <label for="name">Nom *</label>
          <input 
            type="text" 
            id="name" 
            v-model="form.name" 
            autofocus
            :class="{ 'input-error': errors.name }"
          >
          <span v-if="errors.name" class="error-text">{{ errors.name }}</span>
        </div>

        <div class="form-group">
          <label for="email">Email *</label>
          <input 
            type="email" 
            id="email" 
            v-model="form.email"
            :class="{ 'input-error': errors.email }"
          >
          <span v-if="errors.email" class="error-text">{{ errors.email }}</span>
        </div>

        <div class="form-group">
          <label for="password">Contrasenya *</label>
          <input 
            type="password" 
            id="password" 
            v-model="form.password"
            :class="{ 'input-error': errors.password }"
          >
          <span v-if="errors.password" class="error-text">{{ errors.password }}</span>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar contrasenya *</label>
          <input 
            type="password" 
            id="password_confirmation" 
            v-model="form.password_confirmation"
            :class="{ 'input-error': errors.password_confirmation }"
          >
          <span v-if="errors.password_confirmation" class="error-text">{{ errors.password_confirmation }}</span>
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
import * as yup from 'yup';

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const errors = ref({});
const errorMsg = ref(''); 
const loading = ref(false);

const authStore = useAuthStore();
const router = useRouter();

const schema = yup.object({
  name: yup.string()
    .trim()
    .required('El nom és obligatori.'),
    
  email: yup.string()
    .trim()
    .required('El correu electrònic és obligatori.')
    .email('Introdueix un correu electrònic vàlid.'),
    
  password: yup.string()
    .required('La contrasenya és obligatòria.')
    .min(8, 'La contrasenya ha de tindre almenys 8 caràcters.'),
    
  password_confirmation: yup.string()
    .required('Has de confirmar la contrasenya.')
    .oneOf([yup.ref('password')], 'Les contrasenyes no coincideixen.') 
});

const handleRegister = async () => {
  loading.value = true;
  errors.value = {};
  errorMsg.value = '';
  
  try {
    await schema.validate(form.value, { abortEarly: false });
    
    await authStore.register(form.value);
    router.push('/products');
    
  } catch (error) {
    if (error.inner) {
      const newErrors = {};
      error.inner.forEach(err => {
        newErrors[err.path] = err.message;
      });
      errors.value = newErrors;
      
    } else if (error.response && error.response.status === 422) {
      const backendErrors = error.response.data.errors;
      for (const camp in backendErrors) {
        errors.value[camp] = backendErrors[camp][0]; 
      }
      
    } else {
      errorMsg.value = "S'ha produït un error inesperat o de connexió.";
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

.input-error {
  border: 2px solid #dc3545 !important;
  background-color: #fff8f8;
  outline: none;
}

.input-error:focus {
  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
  border-color: #dc3545;
}

.error-text {
  color: #dc3545;
  font-size: 0.85rem;
  font-weight: 500;
  display: block;
  margin-top: 4px;
  margin-bottom: 10px;
  text-align: left;
}
</style>