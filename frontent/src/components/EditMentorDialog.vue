<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import type { MentorType } from '@/types';
import { update } from '@/services/api';

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

const emit = defineEmits(['update:dialogProp']);

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

async function save() {
  const response = await update(mentor);
  console.log(response);
  dialog.value = false;
}
</script>

<template>
  <v-dialog max-width="500px" v-model="dialog">
    <v-card>
      <v-card-title>
        <span class="text-h5">Edit mentor</span>
      </v-card-title>

      <v-card-text>
        <v-text-field v-model="mentor.email" label="E-mail"></v-text-field>
        <v-text-field v-model="mentor.name" label="Name"></v-text-field>
        <v-text-field :disabled="true" v-model="mentor.cpf" label="CPF"></v-text-field>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-darken-1" variant="text" @click="() => (dialog = false)"> Cancel </v-btn>
        <v-btn color="blue-darken-1" variant="text" @click="save"> Save </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
