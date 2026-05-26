import { defineStore } from 'pinia';
import http from '../services/http';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  getters: {
    // Si hay un usuario en el estado, está autenticado
    isAuthenticated: (state) => !!state.user,
  },
  actions: {
async login(credentials) {
      // 1. Pedimos la cookie de seguridad a Laravel (fíjate en la URL exacta)
      await http.get('http://localhost/sanctum/csrf-cookie');
      
      // 2. Hacemos el login. Axios ahora cogerá el token del paso 1 y lo enviará aquí automáticamente.
      const response = await http.post('/login', credentials);
      this.user = response.data;
    },
    async logout() {
      await http.post('/logout');
      this.user = null;
    },

    async fetchUser() {
      try {
        const response = await http.get('/user');
        this.user = response.data;
      } catch (error) {
        this.user = null; // Si da error (ej. 401), limpiamos el usuario
      }
    },
    async register(userData) {
      // 1. Pedimos la cookie CSRF por seguridad (igual que en el login)
      await http.get('http://localhost/sanctum/csrf-cookie');
      
      // 2. Hacemos la petición de registro
      const response = await http.post('/register', userData);
      
      // 3. Como Laravel nos ha logueado automáticamente, guardamos el usuario
      this.user = response.data;
    }
  }
});