<template>
  <v-app>
    <v-main>
      <v-file-input
        show-size
        label="File input"
        @change="uploadFile"
      />
      <v-btn @click="sendFile">
        teste api
      </v-btn>
    </v-main>
  </v-app>
</template>

<script lang="ts" setup>
import FileApi from "@/api/File";
import { ref } from "vue";

const file = ref("");

const uploadFile = (event: any) => {
    console.log(typeof event);
    file.value = event.target.files[0];
    console.log(file.value);
};

const sendFile = async () => {
    const formData = new FormData();
    formData.append("imagem", file.value);
    formData.append("name", file.value.name);

    await FileApi.upload(formData).then((res => {
        console.log(res);
    })).catch((err => {
        console.error(err);
    }));
};
</script>
