<template>
  <v-app>
    <v-main>
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
};
</script>
    