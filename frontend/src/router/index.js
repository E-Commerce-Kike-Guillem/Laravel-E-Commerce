import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView
    },
    {
      path: '/products',
      name: 'Products',
      // Suponiendo que ya existe ProductsView.vue
      component: () => import('../views/ProductsView.vue') 
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
    }
  ]
})

export default router