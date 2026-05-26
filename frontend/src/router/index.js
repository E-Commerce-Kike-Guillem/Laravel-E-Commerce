// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue'; // Asegúrate de tener este archivo
import ProductsView from '../views/ProductsView.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { 
      path: '/', 
      name: 'home', 
      component: HomeView 
    },
    { 
      path: '/products', 
      name: 'products', 
      component: () => import('../views/ProductsView.vue') // Lazy loading (recomendado)
    }
  ]
});

export default router;