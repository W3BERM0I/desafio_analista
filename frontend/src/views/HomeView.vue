<template>
  <v-app>
    <v-main>
      <PNavigation
        home-link="login"
        :sidebar-items="sidebarItems"
        :sidebar-user-items="sidebarUserItems"
      />
      <v-file-input
        show-size
        label="File input"
        @change="select"
      />
      <v-btn @click="sendFile">
        teste api
      </v-btn>
    </v-main>
  </v-app>
</template>
    
<script lang="ts" setup>
import FileApi from "@/api/File";
import { ref, reactive } from "vue";
    
const file = ref("");
const files = reactive([]);
  
const select = (event) => {
    file.value = event?.target.files.item(0);
    createChunks();
};
  
const createChunks = () => {
    files.length = 0; //limpa o array com os arquivos quebrados, caso haja algo dentro
    const size = 1024 * 1024 * 2; // tamanho de cada arquivo
    const chunks = Math.ceil(file.value.size / size); // calculo para saber em quantas partes de 2mb o arquivo vai precisar ser quebrada
  
    for (let i = 0; i < chunks; i++) {
        files.push(file.value.slice(
            i * size,
            Math.min(i * size + size, file.value.size),
            file.value.type
        ));
    }
};
  
const sendFile = async () => {
    FileApi.startEnd().then((res => {
        console.log("start/end");
    }));
    for (const fileChunck of files) {
        const formData = new FormData();
        formData.append("name", file.value.name);
        formData.append("file", fileChunck);
        await FileApi.upload(formData).then((res => {
            console.log(res);
        })).catch((err => {
            console.error(err);
        }));
    }

    FileApi.startEnd().then((res => {
        console.log("start/end");
    }));
};

const sidebarItems = [
    {
        icon: "home",
        text: "Início",
        action: () => (alert("cheguei")),
    },
    {
        icon: "user",
        text: "Meu Perfil",
        action: () => (alert("cheguei")),
    },
    {
        icon: "user-shield",
        text: "Segurança",
        action: () => {},
        children: [
            {
                icon: "lock",
                text: "Alterar Senha",
                action: () => (alert("cheguei")),
            },
            {
                icon: "key",
                text: "Autenticação",
                action: () => (alert("cheguei")),
            },
        ],
    },
    {
        icon: "phone",
        text: "Contatos",
        action: () => (alert("cheguei")),
    },
];

const sidebarUserItems = [
    {
        icon: "right-from-bracket",
        text: "Sair",
        action: async () => {
            try {
                // await loginApi.logout();
                // loginStore.unsetCookies();
                // userStore.unsetUserData();
                // router.push({ name: "Entrar" });
            } catch (error) {
                //
            }
        },
    },
];
</script>
    