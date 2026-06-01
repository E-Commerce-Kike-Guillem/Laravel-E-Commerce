<template>
  <main class="page-content-wrapper">
    <div class="catalog-container container my-5">
      
      <div class="catalog-header-wrapper">
        <h1 class="page-title text-left">
          {{ route.query.category ? 'Productes: ' + route.query.category.charAt(0).toUpperCase() + route.query.category.slice(1) : 'Tots els productes' }}
        </h1>
        
        <select 
          :value="route.query.category || ''"
          @change="handleCategoryChange" 
        >
          <option value="">Tots els productes</option>
          <option value="collars">Collars</option>
          <option value="anells">Anells</option>
          <option value="polseres">Polseres</option>
          <option value="arracades">Arracades</option>
          <option value="piercings">Piercings</option>
        </select>
      </div>

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
            <img :src="'/contenido/productos/' + product.image || '/contenido/placeholder.jpg'" :alt="product.name" />
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
                :class="{ 'is-added': addedProductId === product.id }"
                @click="handleAddToCart(product)" 
                title="Afegir al carret"
              >
                <i :class="addedProductId === product.id ? 'fas fa-check' : 'fas fa-shopping-basket'"></i>
              </button>
            </div>
          </div>
        </div>
      </section>
      
    </div>
  </main>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import http from '../services/http';
import { useCartStore } from '../stores/cartStore';

const cartStore = useCartStore();
const props = defineProps(['product']);
const route = useRoute();
const router = useRouter();
const products = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchProducts = async (category) => {
  loading.value = true;
  error.value = null;
  try {
    const params = category ? { category } : {};
    const response = await http.get('/products', { params });
    products.value = response.data.data || response.data;
  } catch (e) {
    error.value = "No s'ha pogut connectar amb l'API de Laravel.";
    console.error("Error al cargar:", e);
  } finally {
    loading.value = false;
  }
};

watch(
  () => route.query.category,
  (newCat) => {
    fetchProducts(newCat);
  },
  { immediate: true }
);

const handleCategoryChange = (event) => {
  const category = event.target.value;
  if (category === "") {
    router.push({ path: '/products' });
  } else {
    router.push({ path: '/products', query: { category } });
  }
};

const addedProductId = ref(null);

const handleAddToCart = async (product) => {
  await cartStore.addToCart(product);
  
  addedProductId.value = product.id;
  
  setTimeout(() => {
    if (addedProductId.value === product.id) {
      addedProductId.value = null;
    }
  }, 1000);
};

</script>

<style scoped>
@import "@/assets/css/stylesProductes.css";


</style>