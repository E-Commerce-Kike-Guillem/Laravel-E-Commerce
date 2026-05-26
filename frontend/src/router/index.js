import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue'; // Asegúrate de tener este archivo
import ProductsView from '../views/ProductsView.vue';
import LoginView from '../views/LoginView.vue';
import RegisterView from '../views/RegisterView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView
    },
    {
      path: '/product/:id',
      name: 'ProductShow',
      component: () => import('../views/ProductShow.vue')
    },
    {
      path: '/admin/product/:id/edit',
      name: 'ProductEdit',
      component: () => import('../views/ProductEdit.vue')
    },
    { 
      path: '/products', 
      name: 'products', 
      component: ProductsView
    },
    { path: '/login', 
      name: 'login', 
      component: LoginView 
    },
    { path: '/register', 
      name: 'register', 
      component: RegisterView 
    }
  ]
})

export default router