import axios from 'axios';

const http = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: true, // Envía las cookies de sesión
  withXSRFToken: true,   // <-- ¡LA PIEZA QUE FALTABA! Extrae el token CSRF automáticamente
  headers: {
    'Accept': 'application/json',
  }
});

export default http;