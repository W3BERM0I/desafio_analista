<template>
  <v-app>
    <v-main>
      <v-btn @click="teste">
        teste api
      </v-btn>
      <HelloWorld />
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import HelloWorld from "@/components/HelloWorld.vue";

import testeApi from "@/api/teste";

const emits = defineEmits(["nextLevel"]);


const  teste = async () => {
    await testeApi.test().then((res => {
        console.log(res);
    }));

    emits("nextLevel");
};
</script>
