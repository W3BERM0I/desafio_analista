<template>
    <div class="custom-alert" :class="{ 'success': type === 'success', 'error': type === 'error' }">
        <v-icon class="icon" :icon="'fa-' + icon" />
        {{ message }}
    </div>
</template>

<script setup lang="ts">

const props = defineProps({
    icon: {
        type: String,
        required: true,
    },
    message: {
        type: String,
        required: true
    },
    type: {
        type: String,
        required: true
    }
});

</script>

<style scoped>
.custom-alert {
    padding: 5px;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    max-width: 90%;
    margin: 10px auto 0px;
}

.success {
    background-color: #4CAF50;
    color: white;
}

.error {
    background-color: #f44336;
    color: white;
}

.icon {
    font-size: 2rem;
    margin-bottom: 5px;
    margin-right: 12px;
}
</style>