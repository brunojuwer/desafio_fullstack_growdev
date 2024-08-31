<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import type { MentorType, RegisterMentorValidationType } from '@/types';
import { register } from '@/services/api';

const props = defineProps<{
  dialogProp: boolean;
}>();

const mentor = reactive<MentorType>({
  id: '',
  name: '',
  cpf: '',
  email: '',
  password: '',
  role: 'VIEWER'
});

const validationErrors = reactive<RegisterMentorValidationType>({
  name: [],
  email: [],
  password: [],
  cpf: [],
  role: []
});

function clearValidationErrors() {
  for (const key in validationErrors) {
    validationErrors[key as keyof RegisterMentorValidationType] = [];
  }
}

const dialog = ref(props.dialogProp);
const submitting = ref(false);

const emit = defineEmits(['update:dialogProp', 'mentorCreated']);

watch(
  () => props.dialogProp,
  (newValue) => {
    dialog.value = newValue;
  }
);

watch(dialog, (newValue) => {
  if (!newValue) {
    clearValidationErrors();

    emit('update:dialogProp', false);
  }
});

async function save() {
  clearValidationErrors();
  submitting.value = true;
  const response = await register(mentor);
  if (response.status === 201) {
    submitting.value = false;
    emit('mentorCreated');
    dialog.value = false;
    mentor.id = '';
    mentor.name = '';
    mentor.cpf = '';
    mentor.email = '';
    mentor.password = '';
  } else if (response.status === 422) {
    submitting.value = false;
    const errors = response.data.errors;
    for (const key in errors) {
      validationErrors[key as keyof RegisterMentorValidationType] = errors[key];
    }
  }
}
</script>

<template>
  <v-dialog max-width="500px" v-model="dialog">
    <v-card>
      <v-card-title class="text-h5 text-center mt-3"> Create new mentor </v-card-title>

      <v-card-text>
        <v-text-field
          v-model="mentor.name"
          label="Name"
          :error-messages="validationErrors.name"
        ></v-text-field>
        <v-text-field
          v-model="mentor.email"
          label="E-mail"
          :error-messages="validationErrors.email"
        ></v-text-field>
        <v-text-field
          v-model="mentor.cpf"
          label="CPF"
          :error-messages="validationErrors.cpf"
        ></v-text-field>
        <v-text-field
          v-model="mentor.password"
          label="Password"
          type="password"
          :error-messages="validationErrors.password"
        ></v-text-field>
        <v-select
          v-model="mentor.role"
          :error-messages="validationErrors.role"
          :items="['VIEWER', 'ADMIN']"
          label="Role"
        ></v-select>
      </v-card-text>

      <v-card-actions class="my-2">
        <v-spacer></v-spacer>
        <v-btn color="red-darken-1" variant="text" @click="() => (dialog = false)"> Cancel </v-btn>
        <v-btn color="blue-darken-1" :loading="submitting" variant="text" @click="save">
          Create
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
