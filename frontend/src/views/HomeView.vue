<template>
  <div class="home-container">
    <Hero />

    <main class="featured-products ">
      <h2 class="page-title text-center mt-16 mb-10">Productes Destacats</h2>
      <br>
      <section class="showcase">
        
        <div class="product-card" v-for="product in featuredProducts" :key="product.id">
          
          <div class="product-image">
            <img :src="'/contenido/productos/' + product.image || '/contenido/placeholder.jpg'" :alt="product.name">
          </div>
          
          <div class="product-info">
            <h3 class="product-title">{{ product.name }}</h3>
            <p class="product-price">{{ product.price }} €</p>
            
            <div class="product-actions">
              <RouterLink :to="`/product/${product.id}`" class="btn-details-clean">
                Veure més
              </RouterLink>
              
              <button 
                class="btn-cart-icon" 
                @click="addToCart(product)"
                title="Afegir al carret" 
              >
                <i class="fas fa-shopping-basket"></i>
              </button>
            </div>
          </div>
          
        </div>

      </section>
      <section class="container mx-auto my-16 px-4">
  <h2 class="page-title text-center !mt-10">Categories</h2>
  <br>
  <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
    
    <RouterLink 
      v-for="cat in ['collars', 'anells', 'polseres', 'arracades', 'piercings']" 
      :key="cat"
      :to="{ path: '/products', query: { category: cat } }"
      class="category-card group"
    >
      <div class="overflow-hidden rounded-xl shadow-lg transition-transform duration-300 group-hover:scale-105">
        <img 
          :src="`../../public/contenido/productos/${cat}_mod.jpg`" 
          :alt="cat" 
          class="w-full h-40 object-cover"
        >
      </div>
      <p class="mt-4 text-center font-semibold capitalize">{{ cat }}</p>
    </RouterLink>

  </div>
</section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/http'
import Hero from '../components/Hero.vue'

import { useRouter } from 'vue-router';

const router = useRouter();

const featuredProducts = ref([])

const goToCategory = (cat) => {
  store.setCategory(cat); // Guardamos la categoría en memoria
  router.push('/products'); // Navegamos a la vista SIN parámetros
};

const addToCart = (product) => {
  alert(`${product.name} s'ha afegit al carret!`)
}

const fetchFeaturedProducts = async () => {
  try {
    const response = await api.get('/products')
    const allProducts = response.data.data || response.data
    
    // Seleccionamos 3 aleatorios
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

.page-content-wrapper {
  width: 100%;
}

.showcase {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 2rem;
}

.product-card {
  border: 1px solid #eaeaea;
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  background-color: white;
  display: flex;
  flex-direction: column;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.product-image img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.product-info {
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  text-align: left; 
}

.product-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  text-align: left;
}

.product-price {
  font-size: 1.15rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 1rem;
  text-align: left;
}

.product-actions {
  margin-top: auto;
  display: flex;
  justify-content: space-between; 
  align-items: center; 
  padding-top: 1rem;
  border-top: 1px solid #f3f4f6; 
  width: 100%;
}

.btn-details-clean {
  text-decoration: none; 
  color: #555; 
  font-weight: 600;
  padding-left: 0; 
  transition: color 0.2s;
  font-size: 0.95rem;
}

.btn-details-clean:hover {
  color: #000; 
  text-decoration: underline; 
}

.btn-cart-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px; 
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0; 
  flex: 0 0 40px;
  background-color: #243020; 
  color: white;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s, transform 0.2s;
}

.btn-cart-icon:hover {
  transform: scale(1.05);
}

.btn-cart-icon i {
  font-size: 1.1rem;
}
</style>