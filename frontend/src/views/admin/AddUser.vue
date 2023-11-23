<template>
  <v-card>
    <v-card-title>
      <span class="text-h5">Adicionar usuario</span>
    </v-card-title>
    <v-card-text>
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-text-field
              v-model="email"
              label="Email*"
              required
            />
          </v-col>
          <v-col cols="12">
            <v-text-field
              v-model="password"
              label="Senha*"
              type="password"
              required
            />
          </v-col>
        </v-row>
      </v-container>
      <small>A senha deve contar no minimo 7 digitos, ter 1 caractere especial, uma letra maiuscula e uma letra minuscula</small>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn
        color="#3fa110"
        variant="text"
        @click="emits('close');"
      >
        Close
      </v-btn>
      <v-btn
        color="#3fa110"
        variant="text"
        :disabled="loading"
        :loading="loading"
        @click="createUser"
      >
        Save
      </v-btn>
    </v-card-actions>
  </v-card>

  <v-snackbar
    v-model="snackbar"
    multi-line
    color="red"
    rounded="pill"
    elevation="24"
    variant="tonal"
  >
    A senha deve contar no minimo 7 digitos, ter 1 caractere especial, uma letra maiuscula e uma letra minuscula

    <template #actions>
      <v-btn
        color="red"
        variant="text"
        :disabled="loading"
        :loading="loading"
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script lang="ts" setup>
import { ref } from "vue";

import Admin from "@/api/Admin";
const emits = defineEmits(["close"]);

const email = ref("");
const password = ref("");
const mensagem = ref("");
const snackbar = ref(false);
const loading = ref(false);


const validarSenha = (password: string) => {
    const padraoSenha = new RegExp(
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\\¨~?´`!@#$%^&*()_+={}:;.<>,|\[\]\-\/])[0-9a-zA-Z\\¨~?´`!@#$%^&*()_+={}:;.<>,|\[\]\-\/]{8,}$/
    );
    return padraoSenha.test(password);
};

const createUser = ( async () => {
    loading.value = !loading.value;
    if(!validarSenha(password.value)){
        mensagem.value = "A senha deve contar no minimo 7 digitos, ter 1 caractere especial, uma letra maiuscula e uma letra minuscula";
        snackbar.value = true;
    }


    await Admin.createUser(email.value, password.value).then((res => {
        loading.value = !loading.value;
        emits("close");
        console.log(res);
    })).catch((err => {
        console.error(err);
        // snackbar.value = true;
        mensagem.value = "erro ao cadastrar usuario";
        snackbar.value = true;
        loading.value = !loading.value;
    }));

});
</script>