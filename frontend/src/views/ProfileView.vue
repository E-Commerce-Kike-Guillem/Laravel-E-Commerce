<template>
  <main class="page-content-wrapper">
    <div class="container my-5">
      
      <div class="profile-layout">
        
        <aside class="profile-sidebar">
          <div class="user-presentation">
            <div class="avatar-circle">
              {{ authStore.user?.name ? authStore.user.name.charAt(0).toUpperCase() : 'U' }}
            </div>
            <h2 class="user-greeting">Hola, {{ authStore.user?.name || 'Usuari' }}</h2>
            <p class="user-email-text">{{ authStore.user?.email }}</p>
          </div>

          <nav class="profile-nav">
            <a href="#" 
               class="nav-item" 
               :class="{ active: activeTab === 'details' }" 
               @click.prevent="activeTab = 'details'">
               <i class="fas fa-user"></i> Detalls del compte
            </a>
            
            <a href="#" 
               class="nav-item" 
               :class="{ active: activeTab === 'orders' }" 
               @click.prevent="changeToOrdersTab">
               <i class="fas fa-box"></i> Les meves comandes
            </a>
            
            <button @click="authStore.logout" class="nav-item btn-logout"><i class="fas fa-sign-out-alt"></i> Tancar sessió</button>
          </nav>
        </aside>

        <section class="profile-content">
          
          <div v-if="activeTab === 'details'">
            <div class="content-header">
              <h1 class="section-title">Configuració del Perfil</h1>
              <p class="section-subtitle">Gestiona la teva informació personal i la seguretat del teu compte.</p>
            </div>

            <form @submit.prevent="updateProfile" class="modern-form">
              <div class="form-section">
              <h3 class="form-section-title">Informació Personal</h3>
              <div class="form-grid">
                
                <div class="input-group">
                  <label>Nom d'usuari</label>
                  <input 
                    v-model="form.name" 
                    type="text" 
                    class="modern-input"
                    :class="{ 'input-error': errors.name }"
                    placeholder="El teu nom complet"
                    required
                  />
                  <span v-if="errors.name" class="error-text">{{ errors.name[0] }}</span>
                </div>

                <div class="input-group">
                  <label>Adreça electrònica</label>
                  <input 
                    v-model="form.email" 
                    type="email" 
                    class="modern-input"
                    :class="{ 'input-error': errors.email }"
                    placeholder="correu@exemple.com"
                    required
                  />
                  <span v-if="errors.email" class="error-text">{{ errors.email[0] }}</span>
                </div>
              </div>
            </div>

            <hr class="divider">

            <div class="form-section">
              <h3 class="form-section-title">Seguretat</h3>
              <div class="input-group max-w-half">
                <label>Nova contrasenya</label>
                <input 
                  v-model="form.password" 
                  type="password" 
                  class="modern-input"
                  :class="{ 'input-error': errors.password }"
                  placeholder="Deixa en blanc si no vols canviar-la"
                />
                <small class="input-hint" v-if="!errors.password">Utilitza un mínim de 8 caràcters amb lletres i números.</small>
                <span v-if="errors.password" class="error-text">{{ errors.password[0] }}</span>
              </div>
            </div>

              <hr class="divider">

              <div class="form-actions">
                <button type="submit" class="btn-save">
                  <i class="fas fa-save"></i> Guardar canvis
                </button>
              </div>
            </form>
          </div>

          <div v-else-if="activeTab === 'orders'">
            <div class="content-header">
              <h1 class="section-title">Historial de Comandes</h1>
              <p class="section-subtitle">Revisa l'estat i el detall de les teves compres anteriors.</p>
            </div>

            <div v-if="loadingOrders" class="text-center py-4">
              <p>Carregant comandes...</p>
            </div>

            <div v-else-if="orders.length === 0" class="empty-orders">
              <i class="fas fa-box-open empty-icon"></i>
              <h3>Encara no has fet cap comanda</h3>
              <p>Quan compris alguna de les nostres joies, apareixerà aquí.</p>
              <RouterLink to="/products" class="btn-save mt-3" style="display:inline-flex; text-decoration:none;">
                Veure productes
              </RouterLink>
            </div>

            <div v-else class="orders-list">
              <div v-for="order in orders" :key="order.id" class="order-card">
                
                <div class="order-header">
                  <div>
                    <span class="order-id">Comanda #{{ order.id }}</span>
                    <span class="order-date">{{ formatDate(order.created_at) }}</span>
                  </div>
                  <span class="status-badge" :class="order.status.toLowerCase()">
                    {{ translateStatus(order.status) }}
                  </span>
                </div>

                <div class="order-items">
                  <div v-for="item in order.items" :key="item.id" class="order-item-row">
                    <div class="item-name">
                      <span class="item-qty">{{ item.quantity }}x</span> 
                      {{ item.product ? item.product.name : 'Producte descatalogat' }}
                    </div>
                    <div class="item-price">{{ item.price }} €</div>
                  </div>
                </div>

                <div class="order-footer">
                  <span>Total pagat:</span>
                  <span class="order-total">{{ order.total_amount }} €</span>
                </div>
                
              </div>
            </div>

          </div>

        </section>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import * as yup from 'yup';
import http from '../services/http';
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore();

const activeTab = ref('details'); 

const form = ref({ name: '', email: '', password: '' });
const errors = ref({}); 

const profileSchema = yup.object().shape({
  name: yup.string()
    .required('El nom és obligatori'),
  email: yup.string()
    .email('El format del correu no és vàlid')
    .required('El correu electrònic és obligatori'),
  password: yup.string()
    .test(
      'len',
      'La contrasenya ha de tindre almenys 8 caràcters',
      (val) => !val || val.length >= 8
    )
});

onMounted(async () => {
  if (authStore.user) {
    form.value.name = authStore.user.name;
    form.value.email = authStore.user.email;
  }
});

const updateProfile = async () => {
  errors.value = {}; 
  
  try {
    await profileSchema.validate(form.value, { abortEarly: false });

    await http.get('/sanctum/csrf-cookie');
    await http.patch('/profile', form.value);
    
    authStore.user.name = form.value.name;
    authStore.user.email = form.value.email;
    
    form.value.password = '';
    
    alert('Perfil actualitzat correctament!');
  } catch (error) {
    if (error instanceof yup.ValidationError) {
      const yupErrors = {};
      error.inner.forEach((err) => {
        yupErrors[err.path] = [err.message];
      });
      errors.value = yupErrors;
    } 
    else if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } 
    else {
      console.error("Error desconegut:", error);
      alert("S'ha produït un error al guardar les dades.");
    }
  }
};

const orders = ref([]);
const loadingOrders = ref(false);

const changeToOrdersTab = async () => {
  activeTab.value = 'orders';
  loadingOrders.value = true;
  
  try {
    const response = await http.get('/orders');
    orders.value = response.data;
  } catch (error) {
    console.error("Error al carregar les comandes:", error);
  } finally {
    loadingOrders.value = false;
  }
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('ca-ES', options);
};

const translateStatus = (status) => {
  const statuses = {
    'pending': 'Pendent',
    'paid': 'Pagat',
    'shipped': 'Enviat',
    'cancelled': 'Cancel·lat'
  };
  return statuses[status] || status;
};
</script>
<style scoped>

.page-content-wrapper {
  width: 100%;
  min-height: calc(100vh - 100px);
}

.profile-layout {
  display: grid;
  grid-template-columns: 1fr;
  gap: 30px;
  max-width: 1100px;
  margin: 0 auto;
}

@media (min-width: 850px) {
  .profile-layout {
    grid-template-columns: 300px 1fr;
    align-items: start;
  }
}

.profile-sidebar {
  background: white;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.04);
  overflow: hidden;
}

.user-presentation {
  padding: 40px 20px 25px;
  text-align: center;
  border-bottom: 1px solid #f0f0f0;
}

.avatar-circle {
  width: 90px;
  height: 90px;
  background-color: #243020;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  font-family: 'Georgia', serif;
  margin: 0 auto 15px;
  box-shadow: 0 4px 15px rgba(36, 48, 32, 0.3);
}

.user-greeting {
  font-size: 1.3rem;
  font-weight: bold;
  color: #222;
  margin-bottom: 5px;
}

.user-email-text {
  font-size: 0.9rem;
  color: #777;
  margin: 0;
}

.profile-nav {
  display: flex;
  flex-direction: column;
  padding: 15px 0;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 15px 25px;
  color: #555;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.2s ease;
  background: none;
  border: none;
  width: 100%;
  text-align: left;
  font-size: 1rem;
  cursor: pointer;
}

.nav-item i {
  width: 20px;
  text-align: center;
  font-size: 1.1rem;
  color: #999;
}

.nav-item:hover, .nav-item.active {
  background-color: #f5f7f5;
  color: #243020;
}

.nav-item.active {
  border-left: 4px solid #243020;
  font-weight: bold;
}

.nav-item.active i {
  color: #243020;
}

.btn-logout {
  color: #dc3545;
  margin-top: 10px;
}
.btn-logout i {
  color: #dc3545;
}
.btn-logout:hover {
  background-color: #fff5f5;
  color: #c53030;
}

/* --- MAIN CONTENT --- */
.profile-content {
  background: white;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.04);
  padding: 40px;
}

.content-header {
  margin-bottom: 35px;
}

.section-title {
  font-family: 'Georgia', serif;
  font-size: 2rem;
  color: #222;
  margin: 0 0 8px 0;
}

.section-subtitle {
  color: #777;
  font-size: 0.95rem;
  margin: 0;
}

/* --- FORMULARIO --- */
.form-section {
  margin-bottom: 30px;
}

.form-section-title {
  font-size: 1.1rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}

@media (min-width: 600px) {
  .form-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.input-group {
  margin-bottom: 15px;
}

.max-w-half {
  max-width: 400px;
}

.input-group label {
  display: block;
  font-size: 0.85rem;
  font-weight: bold;
  color: #555;
  margin-bottom: 8px;
  text-transform: uppercase;
}

.modern-input {
  width: 100%;
  padding: 14px 16px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  color: #333;
  background-color: #fdfdfd;
  transition: all 0.3s ease;
}

.modern-input:focus {
  outline: none;
  border-color: #243020;
  background-color: #fff;
  box-shadow: 0 0 0 4px rgba(36, 48, 32, 0.1);
}

.input-hint {
  display: block;
  margin-top: 6px;
  font-size: 0.8rem;
  color: #888;
}

.divider {
  border: 0;
  height: 1px;
  background-color: #eaeaea;
  margin: 35px 0;
}

/* --- BOTONES --- */
.form-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 40px;
}

.btn-save {
  background-color: #243020;
  color: white;
  border: none;
  padding: 16px 35px;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-save:hover {
  background-color: #1a2317;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(36, 48, 32, 0.2);
}

.empty-orders {
  text-align: center;
  padding: 40px 20px;
  background-color: #f9fafa;
  border-radius: 12px;
  border: 1px dashed #ccc;
}
.empty-icon {
  font-size: 3rem;
  color: #ccc;
  margin-bottom: 15px;
}
.empty-orders h3 {
  font-family: 'Georgia', serif;
  color: #333;
  margin-bottom: 10px;
}
.empty-orders p {
  color: #777;
}

.orders-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.order-card {
  border: 1px solid #eaeaea;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}

.order-header {
  background-color: #fdfdfd;
  padding: 15px 20px;
  border-bottom: 1px solid #eaeaea;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.order-id {
  font-weight: bold;
  color: #222;
  display: block;
  font-size: 1.05rem;
}

.order-date {
  font-size: 0.85rem;
  color: #777;
}

.status-badge {
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: bold;
  text-transform: uppercase;
}

.status-badge.pending { background-color: #fff3cd; color: #856404; }
.status-badge.paid { background-color: #d4edda; color: #155724; }
.status-badge.shipped { background-color: #cce5ff; color: #004085; }
.status-badge.cancelled { background-color: #f8d7da; color: #721c24; }

.order-items {
  padding: 15px 20px;
}

.order-item-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-bottom: 1px dashed #eee;
  color: #555;
}

.order-item-row:last-child {
  border-bottom: none;
}

.item-qty {
  font-weight: bold;
  color: #222;
  margin-right: 8px;
}

.order-footer {
  background-color: #f9fafa;
  padding: 15px 20px;
  border-top: 1px solid #eaeaea;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #555;
}

.order-total {
  font-weight: bold;
  font-size: 1.2rem;
  color: #243020;
}

input-error {
  border: 2px solid #dc3545 !important;
}

.input-error:focus {
  box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15) !important;
  border-color: #dc3545 !important;
}

.error-text {
  color: #dc3545;
  font-size: 0.85rem;
  font-weight: 500;
  display: block;
  margin-top: 6px;
}
</style>