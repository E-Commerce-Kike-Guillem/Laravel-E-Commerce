<template>
  <div class="home-container">
    
    <Hero />

    <main class="w-full mx-auto px-4 py-8">
      <h2 class="text-3xl font-bold text-center mb-8">Productos Destacados</h2>
      
      <div v-if="loading" class="text-center">Cargando productos...</div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <ProductCard 
          v-for="product in featuredProducts" 
          :key="product.id" 
          :product="product" 
        />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/http' // Tu cliente HTTP ya configurado
import Hero from '../components/Hero.vue'
import ProductCard from '../components/ProductCard.vue'

const featuredProducts = ref([])
const loading = ref(true)

const fetchFeaturedProducts = async () => {
  try {
    // Ajusta el endpoint según las rutas de tu API en Laravel
    const response = await api.get('/products') 
    // Asegúrate de acceder al formato correcto (por ejemplo response.data.data si está paginado)
    featuredProducts.value = response.data.slice(0, 4) 
  } catch (error) {
    console.error('Error al obtener productos destacados:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchFeaturedProducts()
})
</script>

