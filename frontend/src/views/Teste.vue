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
      <v-progress-linear
        v-show="flag"
        color="lime"
        indeterminate
        reverse
      />
    </v-main>
  </v-app>
</template>
  
<script lang="ts" setup>
import FileApi from "@/api/File";
import { ref, reactive } from "vue";
  
const file = ref("");
const flag = ref(false);
const files = reactive([]);

const select = (event) => {
    file.value = event?.target.files.item(0);
    createChunks();
};

const createChunks = () => {
    const size = 1024 * 1024 * 2;
    const chunks = Math.ceil(file.value.size / size);

    for (let i = 0; i < chunks; i++) {
        files.push(file.value.slice(
            i * size,
            Math.min(i * size + size, file.value.size),
            file.value.type
        ));
    }
};

const sendFile = async () => {

    const formData = new FormData();
    formData.append("file", files[0]);
    formData.append("name", file.value.name);

    files.forEach((file) => {
        console.log(file);
    });
    await FileApi.upload1(formData).then((res => {
        console.log(res);
    })).catch((err => {
        console.error(err);
    }));
};
</script>
  