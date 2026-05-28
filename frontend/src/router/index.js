import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProductsView from '../views/ProductsView.vue';
import LoginView from '../views/LoginView.vue';
import RegisterView from '../views/RegisterView.vue';
import AboutView from '../views/AboutView.vue';
import ContactView from '../views/ContactView.vue';
import AdminImportView from '../views/AdminImportView.vue';
import ProfileView from '../views/ProfileView.vue';
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
      name: 'ProductDetailView',
      component: () => import('../views/ProductDetailView.vue')
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
    },
    { 
      path: '/sobre-nosaltres', 
      name: 'about', 
      component: AboutView 
    },
    {
      path: '/contacte',
      name: 'contact',
      component: ContactView
    },
    {
    path: '/admin/importar',
    name: 'AdminImport',
    component: AdminImportView,
    meta: { requiresAdmin: true }
    },
    {
      path: '/perfil',
      name: 'profile',
      component: ProfileView
    }
  ]
})

export default router