<template>
  <div class="home-container">
    <Hero />

    <main class="featured-products mt-16">
      <h2 class="page-title text-center mb-10">Productes Destacats</h2>
      
      <section class="showcase">
  <div v-for="product in featuredProducts" :key="product.id" class="producte-minimal">
    
    <img :src="product.image || '/contenido/placeholder.jpg'" :alt="product.name">
    
    <div class="prod-row-top">
      <h3 class="prod-name">{{ product.name }}</h3>
      <button class="btn-cart-icon" @click="addToCart(product)">
        <i class="fas fa-shopping-basket"></i>
      </button>
    </div>
    
    <p class="prod-price">{{ product.price }} €</p>

    <div class="mt-3">
      <RouterLink :to="`/productes/${product.id}`" class="btn-details-clean">
        Veure detalls
      </RouterLink>
    </div>
    
  </div>
</section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/http'
import Hero from '../components/Hero.vue'

const featuredProducts = ref([])

const addToCart = (product) => {
  alert(`${product.name} s'ha afegit al carret!`)
}

const fetchFeaturedProducts = async () => {
  try {
    const response = await api.get('/products')
    const allProducts = response.data.data || response.data
    
    // Lógica para 3 aleatorios
    featuredProducts.value = allProducts
      .sort(() => 0.5 - Math.random())
      .slice(0, 3)
  } catch (error) {
    console.error('Error:', error)
  }
}

onMounted(fetchFeaturedProducts)
</script>

<style scoped>
@import '@/assets/css/stylesProductes.css';

/* Assegurem l'estil del botó de detalls */
.btn-details-clean {
  text-decoration: none; 
  color: #555; 
  font-weight: 500;
  transition: color 0.2s;
  display: inline-block;
  margin-top: 10px;
}

.btn-details-clean:hover {
  color: #000; 
  text-decoration: underline; 
}

/* Espaiat del grid */
.showcase {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
  margin-top: 20px;
}
</style>