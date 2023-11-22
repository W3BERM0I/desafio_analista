<template>
  <TheContainer>
    <template #out>
      <div class="login">
        <img
          class="login__image"
          src="@/assets/logo-sicredi-pioneira.svg"
          alt="Sicredi Pioneira RS"
        >
        <v-form
          v-model="validForm"
          :disabled="loading"
          class="login__form"
          @submit.prevent="efetuarLogin"
        >
          <h1 class="login__title">
            Iniciar minha sessão
          </h1>

          <v-text-field
            v-model="email"
            label="e-mail"
            autofocus
            aria-label="Informe seu CPF ou CNPJ para entrar no sistema."
            variant="outlined"
            class="mb-3"
            type="email"
            :rules="[rules.requiredEmail]"
          />

          <v-text-field
            v-model="password"
            label="Senha"
            aria-label="Informe sua senha para entrar no sistema."
            maxlength="128"
            variant="outlined"
            class="mb-3"
            :type="mostrarSenha ? 'text' : 'password'"
            :rules="[rules.requiredPassword]"
          >
            <template #append-inner>
              <v-icon
                :aria-label="
                  mostrarSenha ? 'Esconder senha' : 'Mostrar senha'
                "
                role="button"
                @click="mostrarSenha = !mostrarSenha"
              >
                {{
                  mostrarSenha
                    ? "fa-solid fa-eye-slash"
                    : "fa-solid fa-eye"
                }}
              </v-icon>
            </template>
          </v-text-field>

          <error-message />

          <v-btn
            type="submit"
            class="login__submit"
            prepend-icon="fa-solid fa-right-to-bracket"
            color="primary"
          >
            Entrar
          </v-btn>
        </v-form>
      </div>
    </template>
  </TheContainer>

  <v-snackbar
    v-model="snackbar"
    multi-line
    color="red"
    rounded="pill"
    :timeout="4000"
    elevation="24"
    variant="tonal"
  >
    email ou senha invalidos

    <template #actions>
      <v-btn
        color="red"
        variant="text"
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script setup lang="ts">
import Auth from "@/api/Auth";
import TheContainer from "@/components/shared/TheContainer.vue";
import { useUserStore } from "@/store/user";

import { ref } from "vue";
import { useRouter } from "vue-router";
import { UserData } from "@/types";

const router = useRouter();
const userStore = useUserStore();

const mostrarSenha = ref(false);
const loading = ref(false);
const validForm = ref(false);
const email = ref("");
const password = ref("");
const snackbar = ref(false);

const rules = {
    requiredEmail: (value: string) =>
        !!value || "O campo do email é obrigatório.",
    requiredPassword: (value: string) =>
        !!value || "O campo da senha é obrigatório."
};

const efetuarLogin = ( async () => {
    //await Auth.createUser(email.value, password.value).then((res => {
    await Auth.login(email.value, password.value).then((res => {
      
        console.log(res.data);
        userStore.setUserData(res.data as UserData);
        console.log(userStore.user);
        router.push({name: "Home"});
    })).catch((err => {
        snackbar.value = true;
    }));
    return;
});
</script>

<style scoped>
.icon {
    color: var(--verde-escuro);
    border-radius: 5rem;

    width: 7rem;
    height: 7rem;

    font-size: 6rem;

    display: flex;
    justify-content: center;

    background-color: var(--neutro-claro);
}

.icon::before {
    width: 6rem;
    height: 6rem;
}

.login {
    width: 500px;

    border-radius: 0 25px 25px 25px;
    box-shadow: 0px 0px 40px 0px #00000040;

    display: flex;
    flex-direction: column;
    align-items: center;

    padding: 32px;

    text-align: center;

    margin: auto;
}

.login__image {
    width: 75%;
}

.login__title {
    color: var(--verde-escuro);

    margin: 16px 0;
}

.login__form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 75%;
}

.login__recover {
    display: flex;
    justify-content: end;
}

.login__submit {
    margin: 32px auto;
}

.login__recover--link,
.login__signup {
    color: var(--verde-sicredi);
}

.login__signup--icon {
    font-size: medium;
    margin-right: 8px;
}

.teste {
    display: flex;
    justify-content: end;
}

@media screen and (max-width: 960px) {
    .login__title {
        font-size: 1.5rem;
    }
}

@media screen and (max-width: 600px) {
    .login {
        padding: 10px;
        height: 75%;

        justify-content: space-around;
    }

    .login__form {
        width: 90%;
    }
}
</style>
