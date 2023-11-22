<template>
  <div class="container__upload">
    <h3>Adicionar um novo arquivo na base de dados</h3>
    <v-file-input
      show-size
      :disabled="loading"
      label="File input"
      style="width: 90%; max-height: 20%;"
      @change="select"
    />

    <v-progress-linear
      v-if="loading"
      v-model="progress"
      color="#3fa110"
      style="max-width: 95%;"
    />
    <p v-if="uploaded">
      Arquivo carregado
    </p>
    
    <v-btn
      color="primary"
      :disabled="loading"
      :loading="loading"
      @click="sendFile"
    >
      upload
    </v-btn>
  </div>
</template>

<script lang="ts" setup>
import FileApi from "@/api/File";
import { ref, reactive } from "vue";
    
const file = ref("");
const progress = ref(0);
const files = reactive([]);
const loading = ref(false);
const uploaded = ref(false);
  
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
    progress.value = 0;
    loading.value = true;
    uploaded.value = false;
    const progressOnceRequest = 100 / files.length;

    FileApi.startEnd().then((res => {
        console.log("start/end");
    }));
    for (const fileChunck of files) {
        const formData = new FormData();
        formData.append("name", file.value.name);
        formData.append("file", fileChunck);
        await FileApi.upload(formData).then((res => {
            console.log(res);
            progress.value+= progressOnceRequest;
        })).catch((err => {
            console.error(err);
        }));
    }

    FileApi.startEnd().then((res => {
        console.log("start/end");
    }));

    loading.value = false;
    uploaded.value = true;
};
</script>

<style>
.container__upload {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    max-width: 100%;
    gap: 30px;
}
</style>