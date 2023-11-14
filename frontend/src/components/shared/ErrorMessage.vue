<template>
    <div class="error" v-show="errorStore.errorMessage">
        <p class="error__message">{{ errorStore.errorMessage }}</p>
    </div>
</template>

<script setup lang="ts">
import { useErrorStore } from "@/store/error";
import { onMounted } from "vue";
const errorStore = useErrorStore();

onMounted(() => {
    errorStore.unsetError();
});
</script>

<style scoped>
.error {
    color: var(--magenta);
}
</style>
