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

            <button @click="processCheckout" class="btn-checkout">
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
const cartStore = useCartStore();

const increaseQuantity = async (item) => {
  await cartStore.addToCart(item.product);
};

const decreaseQuantity = (item) => {
  if (item.quantity > 1) {
    item.quantity--;
    
  }
};

const processCheckout = async () => {
  const result = await cartStore.checkoutOrder();
  
  if (result.success) {
    alert("Comanda tramitada amb èxit!");
    router.push('/perfil'); 
  } else {
    alert("Hi ha hagut un problema: " + result.message);
  }
};
</script>

<style scoped>
.page-content-wrapper {
  width: 100%;
  min-height: calc(100vh - 140px);
  padding: 1rem 1rem 4rem 1rem;
}

.page-title {
  font-family: 'Georgia', serif;
  font-size: 2.2rem;
  color: #222;
  border-bottom: 2px solid #eaeaea;
  padding-bottom: 15px;
}

.empty-cart-card {
  text-align: center;
  background: white;
  padding: 60px 20px;
  border-radius: 16px;
  border: 1px solid #eaeaea;
  box-shadow: 0 8px 30px rgba(0,0,0,0.03);
  max-width: 600px;
  margin: 0 auto;
}

.empty-icon-wrapper {
  font-size: 4rem;
  color: #ccc;
  margin-bottom: 20px;
}

.empty-cart-card h2 {
  font-family: 'Georgia', serif;
  color: #222;
  margin-bottom: 10px;
}

.empty-cart-card p {
  color: #666;
  margin-bottom: 30px;
}

.btn-continue-shopping {
  display: inline-block;
  background-color: #243020;
  color: white;
  padding: 12px 30px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
}

.btn-continue-shopping:hover {
  background-color: #1a2317;
  transform: translateY(-2px);
}

/* --- LAYOUT DEL CARRO CON PRODUCTOS --- */
.cart-layout {
  display: grid;
  grid-template-columns: 1fr;
  gap: 40px;
  align-items: start;
}

@media (min-width: 992px) {
  .cart-layout {
    grid-template-columns: 1fr 380px; /* 1 Columna ancha, 1 fija a la derecha */
  }
}

/* --- LISTA DE PRODUCTOS --- */
.cart-items-section {
  background: white;
  border-radius: 16px;
  border: 1px solid #eaeaea;
  padding: 20px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.03);
}

.cart-header {
  display: flex;
  font-weight: bold;
  color: #888;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 1px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eaeaea;
  margin-bottom: 20px;
}

.col-product { flex: 3; }
.col-qty { flex: 1; text-align: center; }
.col-price { flex: 1; text-align: right; }
.col-action { width: 50px; text-align: right; }

.cart-item {
  display: flex;
  align-items: center;
  padding: 20px 0;
  border-bottom: 1px solid #f5f5f5;
}

.cart-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.item-product {
  flex: 3;
  display: flex;
  align-items: center;
  gap: 20px;
}

.item-img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid #f0f0f0;
}

.item-name {
  font-family: 'Georgia', serif;
  font-size: 1.2rem;
  color: #222;
  margin: 0 0 5px 0;
}

.item-unit-price {
  font-size: 0.9rem;
  color: #777;
  margin: 0;
}

.item-qty {
  flex: 1;
  text-align: center;
}

.qty-badge {
  background-color: #f9fafa;
  border: 1px solid #ddd;
  padding: 5px 15px;
  border-radius: 20px;
  font-weight: bold;
  color: #333;
}

.item-price {
  flex: 1;
  text-align: right;
  font-size: 1.1rem;
  color: #222;
}

.item-action {
  width: 50px;
  text-align: right;
}

.btn-remove {
  background: none;
  border: none;
  color: #dc3545;
  font-size: 1.1rem;
  cursor: pointer;
  transition: color 0.2s;
}

.btn-remove:hover {
  color: #a71d2a;
}

/* --- RESUMEN DEL PEDIDO --- */
.summary-card {
  background: white;
  border-radius: 16px;
  border: 1px solid #eaeaea;
  padding: 30px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.03);
  position: sticky;
  top: 100px; /* Hace que la tarjeta te siga al hacer scroll */
}

.summary-title {
  font-family: 'Georgia', serif;
  font-size: 1.5rem;
  margin-top: 0;
  margin-bottom: 25px;
  color: #222;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  font-size: 1rem;
  color: #444;
}

.text-muted {
  color: #888;
  font-size: 0.9rem;
}

.summary-divider {
  border: 0;
  height: 1px;
  background-color: #eaeaea;
  margin: 20px 0;
}

.total-row {
  font-size: 1.3rem;
  font-weight: bold;
  color: #222;
  margin-bottom: 30px;
}

.btn-checkout {
  width: 100%;
  background-color: #243020;
  color: white;
  border: none;
  padding: 16px;
  font-size: 1.1rem;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn-checkout:hover {
  background-color: #1a2317;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(36, 48, 32, 0.2);
}

.secure-badges {
  margin-top: 25px;
  text-align: center;
  font-size: 0.85rem;
  color: #666;
}

.secure-badges p {
  margin: 5px 0;
}

.secure-badges i {
  color: #243020;
  width: 20px;
}

.qty-selector {
  display: inline-flex;
  align-items: center;
  background-color: #f9fafa;
  border: 1px solid #ddd;
  border-radius: 20px;
  overflow: hidden;
  margin: 0 auto;
}

.btn-qty {
  background: none;
  border: none;
  padding: 6px 14px;
  font-size: 1.2rem;
  font-weight: bold;
  cursor: pointer;
  color: #555;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-qty:hover:not(:disabled) {
  background-color: #eaeaea;
  color: #243020; /* Tu verde al hacer hover */
}

.btn-qty:disabled {
  color: #ccc;
  cursor: not-allowed;
  background-color: transparent;
}

.qty-number {
  font-weight: bold;
  color: #222;
  min-width: 30px;
  text-align: center;
  font-size: 1rem;
}

/* --- RESPONSIVE MÓVIL --- */
@media (max-width: 768px) {
  .hidden-mobile {
    display: none !important;
  }
  
  .cart-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
    position: relative;
  }
  
  .item-qty, .item-price {
    text-align: left;
    flex: auto;
  }
  
  .item-action {
    position: absolute;
    top: 20px;
    right: 0;
  }
}
</style>