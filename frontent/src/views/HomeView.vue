<script setup lang="ts">
import logoGrowDev from '@/assets/logo-growdev.png';
import EditMentorDialog from '@/components/EditMentorDialog.vue';
import { retrieveMentors } from '@/services/api';
import type { MentorType } from '@/types';
import { reactive, ref, toRaw } from 'vue';

const openEditDialog = ref<boolean>(false);
const mentor = reactive<MentorType>({
  id: '',
  name: '',
  cpf: '',
  email: ''
});

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
function deleteItem(item: any) {
  console.log(item);
}
</script>

<template>
  <header class="bg-grey-darken-4 pa-5">
    <div class="mx-auto px-5 d-flex justify-space-between align-center w-75">
      <img :src="logoGrowDev" alt="Logo GrowDev" width="100px" />
      <h3>Bruno Juwer</h3>
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
      <v-btn color="orange">Add new mentor</v-btn>
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
        <v-icon color="orange" class="me-2" size="small" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon color="red" size="small" @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table-server>
  </main>
  <EditMentorDialog
    :dialog-prop="openEditDialog"
    :mentor-prop="mentor"
    @update:dialogProp="openEditDialog = $event"
  />
</template>
