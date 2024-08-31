<script setup lang="ts">
import { login } from '@/services/api';
import logoGrowDev from '@/assets/logo-growdev.png';
import { resetStorage } from '@/services/authentication';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { setLocalMentorData } from '@/services/mentorStorage';
import type { LoginMentorValidationType } from '@/types';

const email = ref<string>('');
const password = ref<string>('');
const keepConnected = ref<boolean>(false);
const error = ref<string>('');
const router = useRouter();

const submitting = ref(false);

const validationErrors = reactive<LoginMentorValidationType>({
  email: [],
  password: []
});

function clearValidationErrors() {
  for (const key in validationErrors) {
    validationErrors[key as keyof LoginMentorValidationType] = [];
  }
}

async function handleLogin() {
  resetStorage();
  clearValidationErrors();
  error.value = '';
  submitting.value = true;
  const response = await login(email.value, password.value);

  submitting.value = false;

  if (response.status === 201 && keepConnected.value) {
    localStorage.setItem('access_token', response.data.access_token);
    setLocalMentorData(response);
    router.push('/');
  } else if (response.status === 201 && !keepConnected.value) {
    sessionStorage.setItem('access_token', response.data.access_token);
    setLocalMentorData(response);
    router.push('/');
  } else if (response.status === 422) {
    const errors = response.data.errors;
    for (const key in errors) {
      validationErrors[key as keyof LoginMentorValidationType] = errors[key];
    }
  } else {
    error.value = response.data.message;
  }
}
</script>

<template>
  <v-container max-width="600px" class="mt-16">
    <v-img :src="logoGrowDev" alt="Logo GrowDev" :width="100" class="mx-auto my-5" />
    <v-card-title class="text-center my-5 text-h4">Login Mentors</v-card-title>

    <v-text-field
      :error-messages="validationErrors.email"
      label="Email"
      v-model="email"
    ></v-text-field>
    <v-text-field
      :error-messages="validationErrors.password"
      type="password"
      label="Password"
      v-model="password"
    ></v-text-field>

    <div class="keep-connected-container">
      <label for="keep-connected">Keep connected:</label>
      <input type="checkbox" id="keep-connected" v-model="keepConnected" />
    </div>

    <v-btn block @click="handleLogin" :loading="submitting" class="bg-blue-darken-2 my-4"
      >Login</v-btn
    >

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
