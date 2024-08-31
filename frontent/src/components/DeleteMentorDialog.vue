<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import type { MentorType } from '@/types';
import { destroy } from '@/services/api';

const props = defineProps<{
  dialogProp: boolean;
  mentorProp: MentorType;
}>();

const mentor = reactive<MentorType>({
  id: '',
  name: '',
  cpf: '',
  email: ''
});

const dialog = ref(props.dialogProp);

const emit = defineEmits(['update:dialogProp', 'mentorDeleted']);

watch(
  () => props.mentorProp,
  (newValue) => {
    mentor.name = newValue.name;
    mentor.id = newValue.id;
    mentor.cpf = newValue.cpf;
    mentor.email = newValue.email;
  },
  {
    deep: true
  }
);

watch(
  () => props.dialogProp,
  (newValue) => {
    dialog.value = newValue;
  }
);

watch(dialog, (newValue) => {
  if (!newValue) {
    emit('update:dialogProp', false);
  }
});

async function destroyMentor() {
  const response = await destroy(mentor.id);
  if (response.status === 200) {
    emit('mentorDeleted');
  }
  dialog.value = false;
}
</script>

<template>
  <v-dialog max-width="600px" v-model="dialog">
    <v-card class="pt-5">
      <v-card-title class="text-subtitle text-center"
        >Are you sure you want <br />
        to delete <span class="text-orange">{{ mentor.name }}</span> mentor?</v-card-title
      >
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-darken-1" variant="text" @click="() => (dialog = false)"> Cancel </v-btn>
        <v-btn color="red" variant="text" @click="destroyMentor">OK</v-btn>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
