<template>
  <main class="page-content-wrapper">
    <div class="contact-layout container my-5">
      
      <div class="contact-column form-column">
        
        <div v-if="enviado" class="success-message text-center">
          <i class="fas fa-check-circle" style="font-size: 3rem; color: #28a745; margin-bottom: 1rem;"></i>
          <h3>Missatge enviat correctament!</h3>
          <p>Gràcies per contactar amb nosaltres. Et respondrem el més aviat possible.</p>
          <RouterLink to="/" class="btn-modern mt-3 d-inline-block">Tornar a l'inici</RouterLink>
        </div>

        <div v-else>
          <form id="contactForm" @submit.prevent="handleSubmit" novalidate>
            <h3 class="card-title">Contacta amb nosaltres</h3>
            
            <div class="form-group">
              <label for="name">Nom *</label>
              <input type="text" id="name" v-model="form.name" :class="{ 'input-error': errors.name }" required>
              <span v-if="errors.name" class="error-text">{{ errors.name }}</span>
            </div>

            <div class="form-group">
              <label for="email">Correu electrònic *</label>
              <input type="email" id="email" v-model="form.email" :class="{ 'input-error': errors.email }" required>
              <span v-if="errors.email" class="error-text">{{ errors.email }}</span>
            </div>

            <div class="form-group">
              <label for="message">Missatge *</label>
              <textarea id="message" v-model="form.message" :class="{ 'input-error': errors.message }" required></textarea>
              <span v-if="errors.message" class="error-text">{{ errors.message }}</span>
            </div>

            <div class="checkbox-group mt-3">
              <input type="checkbox" id="privacyPolicy" v-model="form.privacyPolicy" required>
              <label for="privacyPolicy">He llegit i accepte la política de privacitat *</label>
            </div>
            <span v-if="errors.privacyPolicy" class="error-text mb-3 d-block">{{ errors.privacyPolicy }}</span>

            <div class="checkbox-group mb-4">
              <input type="checkbox" id="skipValidation" v-model="form.skipValidation">
              <label for="skipValidation" class="text-muted">Desactivar validació en client (per a proves)</label>
            </div>

            <button type="submit" class="btn-modern w-100">Enviar</button>
          </form>
        </div>
      </div>

      <div class="contact-column info-column">
        <h3 class="card-title">Visita'ns i Connecta'ns</h3>
        
        <div class="map-container mb-4">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3114.1638041602555!2d-0.4988051235310471!3d38.69108145885055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd618702fd4eb5b1%3A0xab5dffe40dc99b43!2sCIP%20FP%20Batoi!5e0!3m2!1sca!2ses!4v1780070272235!5m2!1sca!2ses" 
            width="100%" 
            height="250" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>

        <div class="info-grid">
          <div class="info-item">
            <i class="fas fa-map-marker-alt icon"></i>
            <div>
              <strong>Direcció Física</strong>
              <p>Carrer de l'Art, 10,<br>08001 Barcelona</p>
            </div>
          </div>

          <div class="info-item">
            <i class="far fa-envelope icon"></i>
            <div>
              <strong>Email de Suport</strong>
              <p>hola@per-l-art.cat</p>
            </div>
          </div>

          <div class="info-item">
            <i class="fas fa-phone-alt icon"></i>
            <div>
              <strong>Telèfon d'Atenció</strong>
              <p>+34 93 123 45 67</p>
            </div>
          </div>

          <div class="info-item">
            <i class="far fa-calendar-alt icon"></i>
            <div>
              <strong>Horaris de Botiga</strong>
              <p class="mb-0">Dl-Dv: 10:00h - 19:00h</p>
              <p class="mb-0">Ds: 10:00h - 14:00h</p>
              <p>Dg: Tancat</p>
            </div>
          </div>
        </div>

        <div class="social-section mt-4">
          <strong>Segueix-nos</strong>
          <div class="social-icons mt-2">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-pinterest"></i></a>
          </div>
        </div>

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

const errors = ref({}); 
const enviado = ref(false);

const schema = yup.object({
  name: yup.string().trim().required('El nom és obligatori.'),
  email: yup.string().trim().required('El correu electrònic és obligatori.').email('Introdueix un correu electrònic vàlid.'),
  message: yup.string().trim().required('El missatge és obligatori.').min(5, 'El missatge ha de tindre almenys 5 caràcters.'),
  privacyPolicy: yup.boolean().oneOf([true], "Has d'acceptar la política de privacitat.")
});

const handleSubmit = async () => {
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
      const newErrors = {};
      err.inner.forEach(error => {
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


</style>