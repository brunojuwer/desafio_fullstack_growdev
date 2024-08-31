<script setup lang="ts">
import { login } from '@/services/api';
import logoGrowDev from '@/assets/logo-growdev.png';
import { resetStorage } from '@/services/authentication';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const email = ref<string>('');
const password = ref<string>('');
const keepConnected = ref<boolean>(false);
const error = ref<string>('');
const router = useRouter();

const loadingVisible = ref<boolean>(false);

const handleLogin = async () => {
  resetStorage();
  error.value = '';
  loadingVisible.value = true;

  const response = await login(email.value, password.value);

  loadingVisible.value = false;

  if (response.status === 201 && keepConnected.value) {
    localStorage.setItem('access_token', response.data.access_token);
    localStorage.setItem('mentor_name', response.data.mentor_name);
    localStorage.setItem('mentor_role', response.data.mentor_role);
    router.push('/');
  } else if (response.status === 201 && !keepConnected.value) {
    sessionStorage.setItem('access_token', response.data.access_token);
    localStorage.setItem('mentor_name', response.data.mentor_name);
    localStorage.setItem('mentor_role', response.data.mentor_role);
    router.push('/');
  }

  error.value = response.data.message;
};
</script>

<template>
  <v-container max-width="600px" class="mt-16">
    <v-img :src="logoGrowDev" alt="Logo GrowDev" :width="100" class="mx-auto my-5" />
    <v-card-title class="text-center my-5 text-h3">Login Mentors</v-card-title>

    <v-text-field label="Email" v-model="email"></v-text-field>
    <v-text-field type="password" label="Password" v-model="password"></v-text-field>

    <div class="keep-connected-container">
      <label for="keep-connected">Permanecer conectado:</label>
      <input type="checkbox" id="keep-connected" v-model="keepConnected" />
    </div>

    <v-btn block @click="handleLogin" class="bg-blue-darken-2 my-4">Enviar</v-btn>

    <v-card-text class="text-center"
      ><span class="text-red" v-if="error">{{ error }}</span></v-card-text
    >
  </v-container>
</template>

<style scoped>
.keep-connected-container {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}
</style>
