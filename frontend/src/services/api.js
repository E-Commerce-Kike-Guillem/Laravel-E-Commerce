import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost/api', // L'URL de la teva API Laravel
    withCredentials: true, // Necessari per a la gestió de sessions amb Sanctum
});

export default api;