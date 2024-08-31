<script setup lang="ts">
import logoGrowDev from '@/assets/logo-growdev.png';
import AddMentorDialog from '@/components/AddMentorDialog.vue';
import DeleteMentorDialog from '@/components/DeleteMentorDialog.vue';
import EditMentorDialog from '@/components/EditMentorDialog.vue';
import { retrieveMentors, logout } from '@/services/api';
import { resetStorage } from '@/services/authentication';
import type { MentorType } from '@/types';
import { reactive, ref, toRaw } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const mentorRole = localStorage.getItem('mentor_role');
const openEditDialog = ref<boolean>(false);
const openDeleteDialog = ref<boolean>(false);
const openAddMentorDialog = ref<boolean>(false);
const mentor = reactive<MentorType>({
  id: '',
  name: '',
  cpf: '',
  email: ''
});

const loggedMentorName = localStorage.getItem('mentor_name');

const headers = ref<any>([
  { title: 'Name', key: 'name', align: 'end' },
  { title: 'CPF', key: 'cpf', align: 'end' },
  { title: 'E-MAIL', key: 'email', align: 'end' },
  { title: 'ACTIONS', key: 'actions', align: 'end', sortable: false }
]);

const itemsPerPage = ref<number>(5);
const serverItems = ref([]);
const totalItems = ref<number>(0);
const loading = ref<boolean>(false);
const search = ref<string>('');

async function loadItems({ page, sortBy, search }: any) {
  loading.value = true;
  let query = `?per_page=${itemsPerPage.value}&page=${page}`;
  const rawSort = toRaw(sortBy);

  if (search) {
    query += `&searchBy=${search}`;
  }

  if (rawSort.length > 0) {
    query += `&sortBy=${rawSort[0].key}&orderBy=${rawSort[0].order}`;
  }

  const response = await retrieveMentors(query);
  totalItems.value = response.data.paginate.total;
  serverItems.value = response.data.paginate.data;
  loading.value = false;
}

function editItem(item: MentorType) {
  mentor.cpf = item.cpf;
  mentor.email = item.email;
  mentor.name = item.name;
  mentor.id = item.id;
  openEditDialog.value = true;
}
function deleteItem(item: MentorType) {
  mentor.cpf = item.cpf;
  mentor.email = item.email;
  mentor.name = item.name;
  mentor.id = item.id;
  openDeleteDialog.value = true;
}

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

    <v-data-table-server
      class="rounded"
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items="serverItems"
      :items-length="totalItems"
      :loading="loading"
      item-value="name"
      :search="search"
      @update:options="loadItems"
    >
      <template v-slot:item.actions="{ item }: any">
        <v-icon
          color="orange"
          class="me-2"
          size="small"
          :disabled="mentorRole !== 'ADMIN'"
          @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          color="red"
          size="small"
          :disabled="mentorRole !== 'ADMIN'"
          @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table-server>
  </main>
  <AddMentorDialog
    :dialog-prop="openAddMentorDialog"
    @update:dialogProp="openAddMentorDialog = $event"
    @mentorCreated="loadItems({ page: 1, sortBy: [], search })"
  />
  <EditMentorDialog
    :dialog-prop="openEditDialog"
    :mentor-prop="mentor"
    @update:dialogProp="openEditDialog = $event"
    @mentorUpdated="loadItems({ page: 1, sortBy: [], search })"
  />
  <DeleteMentorDialog
    :dialog-prop="openDeleteDialog"
    :mentor-prop="mentor"
    @update:dialogProp="openDeleteDialog = $event"
    @mentorDeleted="loadItems({ page: 1, sortBy: [], search })"
  />
</template>

<style scoped>
.logout-icon:hover {
  opacity: 0.8;
}
</style>
