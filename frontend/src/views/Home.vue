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
const prn = ref("");
const flag = ref(false);
const files = reactive([]);

const uploadFile = (event: any) => {
    flag.value = !flag.value;
    file.value = event.target.files[0];
    const fr = new FileReader();

    fr.readAsText(file.value);

    fr.addEventListener("load", () => {
        prn.value = fr.result;

        // console.log(prn.size);

        splitStringIntoParts();

        files.forEach((element, index) => {
            // console.log(element);
            // console.log("*****************");
            // sendFile1(element);
        });
    });
    flag.value = !flag.value;
    return;
};

const splitStringIntoParts = async () => {
    files.length = 0;
    const chunkSizeInBytes = 1024 * 1024 * 2; //2 mb
    const byteLength = new TextEncoder().encode(prn.value).length;

    for (let offset = 0; offset < byteLength; offset += chunkSizeInBytes) {
        files.push(prn.value.slice(offset, offset + chunkSizeInBytes));
    }

    // console.log(files);
};

const createChuncks = () => {
    const size = 2048;
    const chunk = Math.ceil();
  
};

const sendFile = async () => {
    const formData = new FormData();
    formData.append("file", file.value);
    formData.append("name", file.value.name);

    await FileApi.upload(formData).then((res => {
        console.log(res);
    })).catch((err => {
        console.error(err);
    }));
};

const sendFile1 = async () => {

    await files.forEach((element, index) => {
        console.log(element);
        const formData = new FormData();
        formData.append("file", element.value);
        formData.append("name", "file1");
        
        FileApi.upload(formData).then((res => {
            console.log(res);
        })).catch((err => {
            console.error(err);
        }));
    });
    return;
};
</script>
