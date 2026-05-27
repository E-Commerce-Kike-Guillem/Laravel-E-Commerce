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
          <input type="text" id="name" v-model="form.name" required>

          <label for="email">Correu electrònic *</label>
          <input type="email" id="email" v-model="form.email" required>

          <label for="message">Missatge *</label>
          <textarea id="message" v-model="form.message" required></textarea>

          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <input type="checkbox" id="privacyPolicy" v-model="form.privacyPolicy" required>
            <label for="privacyPolicy" style="margin: 0;">He llegit i accepte la política de privacitat *</label>
          </div>

          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <input type="checkbox" id="skipValidation" v-model="form.skipValidation">
            <label for="skipValidation" style="margin: 0;">Desactivar validació en client (per a proves)</label>
          </div>

          <button type="submit" class="btn">Enviar</button>
        </form>

        <div v-if="errors.length > 0" class="server-errors mt-4">
          <h3>S'han trobat errors:</h3>
          <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>
      </div>
      
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
  name: '',
  email: '',
  message: '',
  privacyPolicy: false,
  skipValidation: false
});

const errors = ref([]);
const enviado = ref(false);

const handleSubmit = () => {
  errors.value = [];

  if (!form.value.skipValidation) {
    if (!form.value.name.trim()) {
      errors.value.push("El nom és obligatori.");
    }
    
    if (!form.value.email.trim()) {
      errors.value.push("El correu electrònic és obligatori.");
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
      errors.value.push("Introdueix un correu electrònic vàlid.");
    }
    
    if (form.value.message.trim().length < 5) {
      errors.value.push("El missatge ha de tindre almenys 5 caràcters.");
    }
    
    if (!form.value.privacyPolicy) {
      errors.value.push("Has d'acceptar la política de privacitat.");
    }
  }

  if (errors.value.length === 0) {
    enviado.value = true;
    
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

.server-errors {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
  padding: 15px;
  border-radius: 8px;
}

.server-errors ul {
  margin: 0;
  padding-left: 20px;
}
</style>