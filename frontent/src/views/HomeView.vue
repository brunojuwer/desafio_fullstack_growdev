<script setup lang="ts">
import logoGrowDev from '@/assets/logo-growdev.png';
import AddMentorDialog from '@/components/AddMentorDialog.vue';
import MentorsDataTable from '@/components/MentorsDataTable.vue';

import { logout } from '@/services/api';
import { resetStorage } from '@/services/authentication';
import { loadItems } from '@/services/mentorDataLoader';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const mentorRole = localStorage.getItem('mentor_role');
const openAddMentorDialog = ref<boolean>(false);

const loggedMentorName = localStorage.getItem('mentor_name');

const search = ref<string>('');

function handleLogout() {
  logout();
  resetStorage();
  router.push('/login');
}
</script>

<template>
  <header class="bg-grey-darken-4 pa-5">
    <div class="mx-auto px-5 d-flex justify-space-between align-center w-75">
      <a href="/">
        <img :src="logoGrowDev" alt="Logo GrowDev" width="100px" />
      </a>
      <div class="d-flex ga-4">
        <h3>{{ loggedMentorName }}</h3>
        <v-icon color="orange" class="logout-icon" @click="handleLogout"> mdi-logout </v-icon>
      </div>
    </div>
  </header>
  <main class="mt-16 w-75 mx-auto">
    <div class="d-flex justify-space-between mb-8 align-center">
      <v-text-field
        class="rounded"
        :max-width="700"
        v-model="search"
        density="comfortable"
        placeholder="Search name, cpf or email..."
        hide-details
      ></v-text-field>
      <v-btn
        color="orange"
        :disabled="mentorRole !== 'ADMIN'"
        @click="() => (openAddMentorDialog = true)"
        >Add new mentor</v-btn
      >
    </div>
    <MentorsDataTable :search="search" />
  </main>
  <AddMentorDialog
    :dialog-prop="openAddMentorDialog"
    @update:dialogProp="openAddMentorDialog = $event"
    @mentorCreated="loadItems({ page: 1, sortBy: [], search })"
  />
</template>

<style scoped>
.logout-icon:hover {
  opacity: 0.8;
}
</style>
