<template>
  <div class="auth-wrapper">
    <div class="auth-container">
      <div class="auth-logo">
        <RouterLink to="/">
          <img src="/contenido/logoParteArriba.png" alt="Logo Per L'Art" />
        </RouterLink>
      </div>

      <h2>Benvingut de nou</h2>
      <p class="subtitle">Introdueix les teves credencials per accedir</p>

      <div v-if="errorMsg" class="error-alert">
        {{ errorMsg }}
      </div>

      <form @submit.prevent="handleLogin" novalidate>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            autofocus
            placeholder="Ex: usuari@email.com"
            :class="{ 'input-error': errors.email }"
          />
          <span v-if="errors.email" class="error-text">{{ errors.email }}</span>
        </div>

        <div class="form-group">
          <label for="password">Contrasenya</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            placeholder="••••••••"
            :class="{ 'input-error': errors.password }"
          />
          <span v-if="errors.password" class="error-text">{{
            errors.password
          }}</span>
        </div>

        <button type="submit" class="btn-auth" :disabled="loading">
          {{ loading ? "Carregant..." : "Entrar" }}
        </button>
        <a href="http://localhost:8080/api/auth/google" class="btn-google">
  <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="google-logo" />
  <span>Iniciar sesión con Google</span>
</a>
      </form>

      <div class="auth-footer">
        <p>
          No tens compte?
          <RouterLink to="/register">Registra't aquí</RouterLink>
        </p>

        <p style="margin-top: 10px">
          <RouterLink to="/">Tornar a la botiga</RouterLink>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/authStore";
import * as yup from "yup";

const form = ref({ email: "", password: "" });
const errors = ref({});
const errorMsg = ref("");
const loading = ref(false);

const authStore = useAuthStore();
const router = useRouter();

const schema = yup.object({
  email: yup
    .string()
    .trim()
    .required("El correu electrònic és obligatori.")
    .email("Introdueix un correu electrònic vàlid."),

  password: yup.string().required("La contrasenya és obligatòria."),
});

const handleLogin = async () => {
  loading.value = true;
  errors.value = {};
  errorMsg.value = "";

  try {
    await schema.validate(form.value, { abortEarly: false });

    await authStore.login(form.value);
    router.push("/products");
  } catch (error) {
    if (error.inner) {
      const newErrors = {};
      error.inner.forEach((err) => {
        newErrors[err.path] = err.message;
      });
      errors.value = newErrors;
    } else {
      errorMsg.value = "Credencials incorrectes o error de connexió.";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
@import "../assets/css/stylesAuth.css";

.btn-google {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  padding: 10px 15px;
  margin-top: 15px;
  background-color: #ffffff;
  border: 1px solid #dadce0;
  border-radius: 8px;
  color: #3c4043;
  font-weight: 500;
  text-decoration: none;
  transition: background-color 0.2s, box-shadow 0.2s;
  cursor: pointer;
}

.btn-google:hover {
  background-color: #f8f9fa;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.google-logo {
  width: 18px;
  height: 18px;
}

.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;

  min-height: calc(100vh - 140px);
  width: 100%;
  background-color: #f9fafb;

  padding: 2.5rem 1rem;
  box-sizing: border-box;
}

.auth-logo {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin-bottom: 1.5rem;
}

.auth-logo img {
  display: block;
  margin: 0 auto;
  max-height: 70px;
  width: auto;
}

.error-alert {
  color: #721c24;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
  text-align: center;
  font-size: 0.9rem;
}

.input-error {
  border: 2px solid #dc3545 !important;
  background-color: #fff8f8;
  outline: none;
}

.input-error:focus {
  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
  border-color: #dc3545;
}

.error-text {
  color: #dc3545;
  font-size: 0.85rem;
  font-weight: 500;
  display: block;
  margin-top: 4px;
  margin-bottom: 10px;
  text-align: left;
}
</style>
