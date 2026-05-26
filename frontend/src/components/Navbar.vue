<template>
  <header class="header-exacto">
    <div class="header-logo-container">
      <RouterLink to="/">
        <img src="/contenido/logoParteArriba.png" alt="Logo">
      </RouterLink>
    </div>

    <div class="header-right-side">
      <nav class="nav-links-clean">
        <RouterLink class="nav-link" to="/products">Productes</RouterLink>
        <RouterLink class="nav-link" to="/sobre-nosaltres">Sobre nosaltres</RouterLink>
        <RouterLink class="nav-link" to="/contacte">Contacte</RouterLink>

        <template v-if="authStore.isAuthenticated">
          <RouterLink class="nav-link" to="/profile">Mi Perfil</RouterLink>
          
          <button @click="handleLogout" class="nav-link logout-btn">
            Cerrar Sesión
          </button>
        </template>
        
        <template v-else>
          <RouterLink class="nav-link" to="/login">Iniciar Sesión</RouterLink>
        </template>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>

<style scoped>

@import '../assets/css/common.css';

.logout-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-family: inherit;
  font-size: inherit;
  padding: 0;
}

.header-logo-container {
    margin-left: 30px; /* Ajusta aquest valor al teu gust */
}

/* 2. Engrandir els enllaços */
.nav-links-clean .nav-link {
    font-size: 1.2rem;       /* Farem la font més gran (el valor per defecte sol ser 1rem) */
    font-weight: 500;        /* Una mica més de gruix perquè es vegi millor */
    padding: 10px 15px;      /* Més espai al voltant dels enllaços */
    text-decoration: none;
    color: #333;             /* Assegura't que el color sigui el que vulguis */
}

/* 3. Opcional: efecte en passar el ratolí per sobre */
.nav-links-clean .nav-link:hover {
    color: #000;
    transform: scale(1.05);  /* Petit efecte de creixement al passar el ratolí */
    transition: 0.2s;
}

/* 4. Ajustar l'alçada del header per encabir els enllaços grans */
.header-exacto {
    height: 100px; 
    display: flex;
    align-items: center; /* Centra verticalment tant el logo com els enllaços */
}

</style>