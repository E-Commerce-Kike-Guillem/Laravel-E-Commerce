<template>
  <section class="hero bg-gray-200 py-20 text-center">
    <div class="container mx-auto px-4">
      <h1 class="text-5xl font-extrabold mb-4">Bienvenido a la Tienda</h1>
      <p class="text-xl mb-8">Descubre nuestros productos exclusivos</p>
      <button 
        @click="goToShop"
        class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition"
      >
        Ver Catálogo
      </button>
    </div>
  </section>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goToShop = () => {
  router.push('/products')
}
</script>