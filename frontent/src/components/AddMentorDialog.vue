<script setup lang="ts">
import { reactive, ref } from 'vue';

interface MentorType {
  id: string;
  name: string;
  email: string;
  cpf: string;
}

const mentor = reactive<MentorType>({
  id: '',
  name: '',
  cpf: '',
  email: ''
});

const dialogProps = defineProps<{
  dialogProp: boolean;
}>();

const dialog = ref<boolean>(dialogProps.dialogProp);

function close() {
  console.log('close');
}

function save() {
  console.log('save');
}
</script>

<template>
  <v-dialog v-model="dialog" max-width="500px">
    <template v-slot:activator="{ props }">
      <v-btn class="mb-2" color="primary" dark v-bind="props"> New Item </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="text-h5">Add new mentor</span>
      </v-card-title>

      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12" md="4" sm="6">
              <v-text-field v-model="mentor.name" label="Name"></v-text-field>
            </v-col>
            <v-col cols="12" md="4" sm="6">
              <v-text-field v-model="mentor.cpf" label="CPF"></v-text-field>
            </v-col>
            <v-col cols="12" md="4" sm="6">
              <v-text-field v-model="mentor.email" label="E-mail"></v-text-field>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-darken-1" variant="text" @click="close"> Cancel </v-btn>
        <v-btn color="blue-darken-1" variant="text" @click="save"> Save </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
