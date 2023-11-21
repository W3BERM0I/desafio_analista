<template>
  <div class="container__upload">
    <!-- <p>Adicionar um novo arquivo</p>
    <v-icon
      class="button__icon"
      icon="fa-upload fa-solid"
    /> -->
    <v-file-input
      show-size
      label="File input"
      @change="select"
    />
    <v-btn @click="sendFile">
      teste api
    </v-btn>
  </div>
</template>

<style>
.container__upload {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
</style>