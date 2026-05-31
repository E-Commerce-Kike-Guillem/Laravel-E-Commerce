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
            <a href="#" class="nav-item active"><i class="fas fa-user"></i> Detalls del compte</a>
            <a href="#" class="nav-item"><i class="fas fa-box"></i> Les meves comandes</a>
            <a href="#" class="nav-item"><i class="fas fa-map-marker-alt"></i> Adreces</a>
            <button class="nav-item btn-logout"><i class="fas fa-sign-out-alt"></i> Tancar sessió</button>
          </nav>
        </aside>

        <section class="profile-content">
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
                    placeholder="El teu nom complet"
                  />
                </div>

                <div class="input-group">
                  <label>Adreça electrònica</label>
                  <input 
                    v-model="form.email" 
                    type="email" 
                    class="modern-input"
                    placeholder="correu@exemple.com"
                  />
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
                  placeholder="Deixa en blanc si no vols canviar-la"
                />
                <small class="input-hint">Utilitza un mínim de 8 caràcters amb lletres i números.</small>
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Guardar canvis
              </button>
            </div>

          </form>
        </section>
        
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import http from '../services/http';
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore();
const form = ref({ name: '', email: '', password: '' });

onMounted(async () => {
  if (authStore.user) {
    form.value.name = authStore.user.name;
    form.value.email = authStore.user.email;
  }
});

const updateProfile = async () => {
  try {
    await http.get('/sanctum/csrf-cookie');
    await http.patch('/profile', form.value);
    
    authStore.user.name = form.value.name;
    authStore.user.email = form.value.email;
    
    alert('Perfil actualitzat correctament!');
  } catch (error) {
    console.error("Error:", error);
  }
};
</script>

<style scoped>

.page-content-wrapper {
  width: 100%;
  min-height: calc(100vh - 100px);
}

/* Layout Grid: 1 Columna en móvil, 2 en PC */
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

/* --- SIDEBAR --- */
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
</style>