<template>
  <main class="page-content-wrapper">
    <div class="container my-5">
      <h1 class="page-title mb-5">Finalitzar Compra</h1>

      <div class="checkout-layout">
        
        <section class="checkout-form-section">
          <div class="content-header">
            <h2 class="section-title text-xl">Dades d'enviament</h2>
            <p class="section-subtitle">Introdueix on vols rebre les teves joies.</p>
          </div>

          <form @submit.prevent="processPayment" class="modern-form mt-4">
            
            <div class="form-grid">
              <div class="input-group">
                <label>Nom i Cognoms</label>
                <input v-model="form.name" type="text" class="modern-input" :class="{ 'input-error': errors.name }" placeholder="Ex: Joan Pérez" />
                <span v-if="errors.name" class="error-text">{{ errors.name[0] }}</span>
              </div>

              <div class="input-group">
                <label>Correu electrònic</label>
                <input v-model="form.email" type="email" class="modern-input" :class="{ 'input-error': errors.email }" placeholder="correu@exemple.com" />
                <span v-if="errors.email" class="error-text">{{ errors.email[0] }}</span>
              </div>
            </div>

            <div class="form-grid">
              <div class="input-group">
                <label>Telèfon</label>
                <input v-model="form.phone" type="text" class="modern-input" :class="{ 'input-error': errors.phone }" placeholder="Ex: 600 123 456" />
                <span v-if="errors.phone" class="error-text">{{ errors.phone[0] }}</span>
              </div>
            </div>

            <div class="input-group mt-3">
              <label>Adreça completa</label>
              <input v-model="form.address" type="text" class="modern-input" :class="{ 'input-error': errors.address }" placeholder="Carrer, Número, Pis, Porta..." />
              <span v-if="errors.address" class="error-text">{{ errors.address[0] }}</span>
            </div>

            <div class="form-grid mt-3">
              <div class="input-group">
                <label>Ciutat</label>
                <input v-model="form.city" type="text" class="modern-input" :class="{ 'input-error': errors.city }" placeholder="Ex: Barcelona" />
                <span v-if="errors.city" class="error-text">{{ errors.city[0] }}</span>
              </div>

              <div class="input-group">
                <label>Codi Postal</label>
                <input v-model="form.zip" type="text" class="modern-input" :class="{ 'input-error': errors.zip }" placeholder="Ex: 08001" />
                <span v-if="errors.zip" class="error-text">{{ errors.zip[0] }}</span>
              </div>
            </div>

            <hr class="divider">
            <h2 class="section-title text-xl mb-4">Mètode de Pagament</h2>
            
            <div class="mock-card-payment">
              <i class="fas fa-credit-card text-2xl text-gray-600"></i>
              <span>Pagament segur amb Targeta / Apple Pay</span>
            </div>

          </form>
        </section>

        <aside class="checkout-summary-section">
          <div class="summary-card">
            <h3 class="summary-title">Resum de la comanda</h3>

            <div class="mini-cart-items">
              <div v-for="item in cartStore.items" :key="item.product.id" class="mini-item">
                <span class="mini-qty">{{ item.quantity }}x</span>
                <span class="mini-name">{{ item.product.name }}</span>
                <span class="mini-price">{{ (item.product.price * item.quantity).toFixed(2) }} €</span>
              </div>
            </div>

            <hr class="summary-divider" />

            <div class="summary-row">
              <span>Subtotal</span>
              <span>{{ cartStore.totalPrice.toFixed(2) }} €</span>
            </div>
            
            <div class="summary-row text-muted">
              <span>Enviament</span>
              <span>Gratuït</span>
            </div>

            <hr class="summary-divider" />

            <div class="summary-row total-row">
              <span>Total a pagar</span>
              <span>{{ cartStore.totalPrice.toFixed(2) }} €</span>
            </div>

            <button @click="processPayment" class="btn-pay" :disabled="isProcessing">
              <span v-if="isProcessing"><i class="fas fa-spinner fa-spin"></i> Processant...</span>
              <span v-else>Pagar i Finalitzar <i class="fas fa-arrow-right ml-2"></i></span>
            </button>
            
            <div class="secure-badges">
              <p><i class="fas fa-lock"></i> Entorn xifrat i segur</p>
            </div>
          </div>
        </aside>

      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import * as yup from 'yup';
import { useAuthStore } from '../stores/authStore';
import { useCartStore } from '../stores/cartStore';

const router = useRouter();
const authStore = useAuthStore();
const cartStore = useCartStore();

const isProcessing = ref(false);
const errors = ref({});

const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  zip: ''
});

const checkoutSchema = yup.object().shape({
  name: yup.string().required('El nom és obligatori'),
  email: yup.string().email('Format de correu invàlid').required('El correu és obligatori'),
  phone: yup.string()
    .matches(/^[0-9]{9}$/, 'El telèfon ha de tindre 9 números')
    .required('El telèfon és obligatori'),
  address: yup.string().min(5, 'Adreça massa curta').required("L'adreça és obligatòria"),
  city: yup.string().required('La ciutat és obligatòria'),
  zip: yup.string()
    .matches(/^[0-9]{5}$/, 'El codi postal han de ser 5 números')
    .required('El codi postal és obligatori'),
});

onMounted(() => {
  if (cartStore.items.length === 0) {
    router.push('/cart');
    return;
  }
  
  if (!authStore.user) {
    router.push('/login');
    return;
  }

  form.value.name = authStore.user.name;
  form.value.email = authStore.user.email;
});

const processPayment = async () => {
  errors.value = {};

  try {
    await checkoutSchema.validate(form.value, { abortEarly: false });
    
    isProcessing.value = true;

    await new Promise(resolve => setTimeout(resolve, 2000));

    const result = await cartStore.checkoutOrder();

    if (result.success) {
      alert("Pagament realitzat amb èxit! Gràcies per la teva compra.");
      router.push('/perfil'); 
    } else {
      alert("Error en registrar la comanda al servidor: " + result.message);
      isProcessing.value = false;
    }

  } catch (error) {
    if (error instanceof yup.ValidationError) {
      const yupErrors = {};
      error.inner.forEach((err) => {
        yupErrors[err.path] = [err.message];
      });
      errors.value = yupErrors;
    }
  }
};
</script>

<style scoped>
@import '@/assets/css/checkout.css';

</style>