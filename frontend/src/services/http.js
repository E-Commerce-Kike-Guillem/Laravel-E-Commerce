import axios from 'axios';

const http = axios.create({
  baseURL: 'http://localhost/api',
  withCredentials: true, // Envía las cookies de sesión
  withXSRFToken: true,   // <-- ¡LA PIEZA QUE FALTABA! Extrae el token CSRF automáticamente
  headers: {
    'Accept': 'application/json',
  }
});

export default http;