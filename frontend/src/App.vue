<template>
  <div class="layout-principal">
    
    <div class="navbar-wrapper">
      <Navbar />
    </div>
    
    <main class="page-content">
      <RouterView />
    </main>
    
    <Footer />
    <Chatbot />


  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue' 
import Chatbot from './components/Chatbot.vue';
import { onMounted } from 'vue';
import { useAuthStore } from './stores/authStore';

const authStore = useAuthStore();

onMounted(async () => {
  await authStore.fetchUser(); 
});
</script>

<style>
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
}

#app, .layout-principal {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.navbar-wrapper {
  position: sticky;
  top: 0;
  z-index: 9999;
  width: 100%;
  background-color: white; 
  box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
}

.page-content {
  flex-grow: 1; 
  display: flex; 
  flex-direction: column;
}</style>