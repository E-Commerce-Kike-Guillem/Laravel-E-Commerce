<template>
  <main class="page-content-wrapper">
    <div class="contact-wrapper container my-5">
      
      <div v-if="enviado" class="success-message text-center">
        <h3>Missatge enviat correctament!</h3>
        <p>Gràcies per contactar amb nosaltres.</p>
        <RouterLink to="/" class="btn-details-clean mt-3 d-inline-block">Tornar a l'inici</RouterLink>
      </div>

      <div v-else>
        <form id="contactForm" @submit.prevent="handleSubmit" novalidate>
          <h3>Contacta amb nosaltres</h3>
          
          <label for="name">Nom *</label>
          <input type="text" id="name" v-model="form.name" :class="{ 'input-error': errors.name }" required>
          <span v-if="errors.name" class="error-text">{{ errors.name }}</span>

          <label for="email">Correu electrònic *</label>
          <input type="email" id="email" v-model="form.email" :class="{ 'input-error': errors.email }" required>
          <span v-if="errors.email" class="error-text">{{ errors.email }}</span>

          <label for="message">Missatge *</label>
          <textarea id="message" v-model="form.message" :class="{ 'input-error': errors.message }" required></textarea>
          <span v-if="errors.message" class="error-text">{{ errors.message }}</span>

          <div class="checkbox-group">
            <input type="checkbox" id="privacyPolicy" v-model="form.privacyPolicy" required>
            <label for="privacyPolicy">He llegit i accepte la política de privacitat *</label>
          </div>
          <span v-if="errors.privacyPolicy" class="error-text mb-3">{{ errors.privacyPolicy }}</span>

          <div class="checkbox-group mb-4">
            <input type="checkbox" id="skipValidation" v-model="form.skipValidation">
            <label for="skipValidation">Desactivar validació en client (per a proves)</label>
          </div>

          <button type="submit" class="btn">Enviar</button>
        </form>
      </div>
      
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue';
import * as yup from 'yup';

const form = ref({
  name: '',
  email: '',
  message: '',
  privacyPolicy: false,
  skipValidation: false
});

// ¡CAMBIO!: Ahora errors es un objeto, no un array
const errors = ref({}); 
const enviado = ref(false);

const schema = yup.object({
  name: yup.string()
    .trim()
    .required('El nom és obligatori.'),
  
  email: yup.string()
    .trim()
    .required('El correu electrònic és obligatori.')
    .email('Introdueix un correu electrònic vàlid.'),
  
  message: yup.string()
    .trim()
    .required('El missatge és obligatori.')
    .min(5, 'El missatge ha de tindre almenys 5 caràcters.'),
  
  privacyPolicy: yup.boolean()
    .oneOf([true], "Has d'acceptar la política de privacitat.")
});

const handleSubmit = async () => {
  // Limpiamos el objeto de errores en cada intento
  errors.value = {};

  if (form.value.skipValidation) {
    enviado.value = true;
    return;
  }

  try {
    await schema.validate(form.value, { abortEarly: false });
    enviado.value = true;
    
  } catch (err) {
    if (err.inner) {
      // Mapeamos cada error de Yup a su campo correspondiente
      const newErrors = {};
      err.inner.forEach(error => {
        // Yup nos da el nombre del campo en error.path
        newErrors[error.path] = error.message; 
      });
      errors.value = newErrors;
    } else {
      console.error(err);
    }
  }
};
</script>
<style scoped>
@import '@/assets/css/stylesContact.css';

.page-content-wrapper {
  width: 100%;
  display: flex;
  justify-content: center;
}

.contact-wrapper {
  width: 100%;
  max-width: 600px; 
  margin: 0 auto;
}

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 5px;
}

.checkbox-group label {
  margin: 0;
}

/* --- NUEVOS ESTILOS DE ERROR --- */
.input-error {
  border: 2px solid #dc3545 !important; /* Borde rojo */
  background-color: #fff8f8; /* Fondo ligeramente rojizo */
  outline: none;
}

.input-error:focus {
  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25); /* Resplandor rojo al hacer clic */
  border-color: #dc3545;
}

.error-text {
  color: #dc3545;
  font-size: 0.85rem;
  font-weight: 500;
  display: block;
  margin-top: -10px; /* Sube el texto para pegarlo al input */
  margin-bottom: 15px; /* Empuja el siguiente campo hacia abajo */
}
</style>