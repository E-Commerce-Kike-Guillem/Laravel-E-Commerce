<template>
  <main class="page-content-wrapper">
    <div class="container my-5">
      <h1 class="page-title mb-5">El teu Carret</h1>

      <div v-if="cartStore.items.length === 0" class="empty-cart-card">
        <div class="empty-icon-wrapper">
          <i class="fas fa-shopping-bag"></i>
        </div>
        <h2>El teu carret és buit</h2>
        <p>Sembla que encara no has afegit cap joia. Descobreix les nostres col·leccions!</p>
        <RouterLink to="/products" class="btn-continue-shopping">
          Veure productes
        </RouterLink>
      </div>

      <div v-else class="cart-layout">
        
        <section class="cart-items-section">
          <div class="cart-header hidden-mobile">
            <div class="col-product">Producte</div>
            <div class="col-qty">Quantitat</div>
            <div class="col-price">Total</div>
            <div class="col-action"></div>
          </div>

          <div v-for="item in cartStore.items" :key="item.product.id" class="cart-item">
            
            <div class="item-product">
              <img :src="'/contenido/productos/' + item.product.image" :alt="item.product.name" class="item-img" />
              <div class="item-details">
                <h3 class="item-name">{{ item.product.name }}</h3>
                <p class="item-unit-price">{{ item.product.price }} € / unitat</p>
              </div>
            </div>

            <div class="item-qty">
              <div class="qty-selector">
                <button 
                  @click="decreaseQuantity(item)" 
                  class="btn-qty" 
                  :disabled="item.quantity <= 1"
                  title="Disminuir"
                >-</button>
                
                <span class="qty-number">{{ item.quantity }}</span>
                
                <button 
                  @click="increaseQuantity(item)" 
                  class="btn-qty"
                  title="Augmentar"
                >+</button>
              </div>
            </div>

            <div class="item-price">
              <strong>{{ (item.product.price * item.quantity).toFixed(2) }} €</strong>
            </div>

            <div class="item-action">
              <button @click="cartStore.removeFromCart(item.product.id)" class="btn-remove" title="Eliminar">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </section>

        <aside class="cart-summary-section">
          <div class="summary-card">
            <h3 class="summary-title">Resum de la comanda</h3>

            <div class="summary-row">
              <span>Subtotal ({{ cartStore.totalItems }} articles)</span>
              <span>{{ cartStore.totalPrice.toFixed(2) }} €</span>
            </div>

            <div class="summary-row text-muted">
              <span>Enviament</span>
              <span>Gratuit!</span>
            </div>

            <hr class="summary-divider" />

            <div class="summary-row total-row">
              <span>Total</span>
              <span>{{ cartStore.totalPrice.toFixed(2) }} €</span>
            </div>

            <button @click="proceedToCheckout" class="btn-checkout">
              Tramitar Comanda <i class="fas fa-lock ml-2"></i>
            </button>

            <div class="secure-badges">
              <p><i class="fas fa-shield-alt"></i> Pagament 100% segur</p>
              <p><i class="fas fa-undo"></i> Devolucions en 30 dies</p>
            </div>
          </div>
        </aside>

      </div>
    </div>
  </main>
</template>

<script setup>
import { useCartStore } from '../stores/cartStore';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

const cartStore = useCartStore();
const router = useRouter();
const authStore = useAuthStore();

const proceedToCheckout = () => {
  if (!authStore.isAuthenticated) {
    alert("Has d'iniciar sessió per poder tramitar la comanda.");
    router.push('/login'); 
    return;
  }
  router.push('/checkout'); 
};

const increaseQuantity = async (item) => {
  await cartStore.addToCart(item.product);
};

const decreaseQuantity = (item) => {
  if (item.quantity > 1) {
    item.quantity--;
    
  }
};

</script>

<style scoped>
@import '@/assets/css/cart.css';

</style>