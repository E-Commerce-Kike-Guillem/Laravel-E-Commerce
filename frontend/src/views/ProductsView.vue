<template>
  <main class="page-content-wrapper">
    <div class="catalog-container container my-5">
      <h1 class="page-title text-left mb-5">Tots els productes:</h1>

      <div v-if="loading" class="text-center">
        <div class="spinner-border text-primary d-block mx-auto" role="status">
          <span class="visually-hidden">Carregant...</span>
        </div>
      </div>

      <div v-else-if="error" class="alert alert-danger text-center" role="alert">
         {{ error }}
      </div>

      <section v-else class="showcase" id="lista-productos">
        
        <div class="product-card" v-for="product in products" :key="product.id">
          
          <div class="product-image">
            <img :src="product.image || '/contenido/placeholder.jpg'" :alt="product.name">
          </div>
          
          <div class="product-info">
            <h3 class="product-title">{{ product.name }}</h3>
            <p class="product-price">{{ product.price }} €</p>
            
            <div class="product-actions">
  
              <RouterLink :to="`/productes/${product.id}`" class="btn btn-link btn-details-clean">
                Veure detalls
              </RouterLink>
              
              <button 
                class="btn btn-dark btn-cart-icon" 
                @click="addToCart(product)"
                title="Afegir al carret" 
              >
                <i class="fas fa-shopping-basket"></i>
              </button>

            </div>
          </div>
          
        </div>

      </section>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import http from '../services/http'; 

const products = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const response = await http.get('/products');
    
    products.value = response.data.data || response.data;
  } catch (e) {
    error.value = "No s'ha pogut connectar amb l'API de Laravel.";
    console.error(e);
  } finally {
    loading.value = false;
  }
});

const addToCart = (product) => {
  console.log('Afegint al carret:', product.name);
  alert(`${product.name} s'ha afegit al carret!`);
};
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
}

.product-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.product-price {
  font-size: 1rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 1rem;
}

.product-actions {
  margin-top: auto;
  display: flex;
  justify-content: space-between; 
  align-items: center;
  padding-top: 1rem;
}

.btn-details-clean {
  text-decoration: none; 
  color: #555; 
  font-weight: 500;
  padding-left: 0; 
  transition: color 0.2s;
}

.btn-details-clean:hover {
  color: #000; 
  text-decoration: underline; 
}

.btn-cart-icon {
  width: 45px;
  height: 45px;
  border-radius: 8px; 
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0; 
  flex: 0 0 45px; 
}

.btn-cart-icon i {
  font-size: 1.2rem;
  }
</style>