<script setup lang="ts">
import DeleteMentorDialog from '@/components/DeleteMentorDialog.vue';
import EditMentorDialog from '@/components/EditMentorDialog.vue';
import type { MentorType } from '@/types';
import { reactive, ref } from 'vue';
import {
  loadItems,
  itemsPerPage,
  serverItems,
  totalItems,
  loading
} from '@/services/mentorDataLoader';

const mentor = reactive<MentorType>({
  id: '',
  name: '',
  cpf: '',
  email: ''
});

defineProps<{ search: string }>();

const openEditDialog = ref<boolean>(false);
const openDeleteDialog = ref<boolean>(false);

const mentorRole = localStorage.getItem('mentor_role');

const headers = ref<any>([
  { title: 'Name', key: 'name', align: 'end' },
  { title: 'CPF', key: 'cpf', align: 'end' },
  { title: 'E-MAIL', key: 'email', align: 'end' },
  { title: 'ACTIONS', key: 'actions', align: 'end', sortable: false }
]);

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
</script>
<template>
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
      <v-icon color="red" size="small" :disabled="mentorRole !== 'ADMIN'" @click="deleteItem(item)">
        mdi-delete
      </v-icon>
    </template>
  </v-data-table-server>

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
