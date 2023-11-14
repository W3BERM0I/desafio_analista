<template>
    <button
        class="button"
        type="button"
        :class="{ 'button--disabled': disabled }"
        :disabled="disabled"
    >
        <div
            class="button__icon--container"
            :class="{ 'button__icon--disabled': disabled }"
        >
            <v-progress-circular indeterminate v-if="loading" />
            <v-icon v-else class="button__icon" :icon="'fa-' + icon" />
        </div>
        <div class="button__content">
            <h3
                class="button__title"
                :class="{ 'button__title--disabled': disabled }"
            >
                {{ regularTitle }} <strong>{{ boldTitle }}</strong>
            </h3>
            <p class="button__subtitle">
                {{ subtitle }}
            </p>
        </div>
    </button>
</template>

<script setup lang="ts">
const props = defineProps({
    icon: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        required: true,
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false,
    },
    loading: {
        type: Boolean,
        required: false,
        default: false,
    },
});

const arrayTitle = props.title.split(" ");
const boldTitle = arrayTitle.slice(-1).join(" ");
const regularTitle = arrayTitle.slice(0, -1).join(" ");
</script>

<style scoped>
.button {
    display: flex;
    width: 40%;
    min-width: 300px;
    padding: 32px 12px;
    box-shadow: 0 0 10px var(--neutro-claro);
    cursor: pointer;
    text-align: left;
    transition: 0.5s;
}

.button:hover,
.button:focus {
    transform: scale(1.05);
}

.button__icon--container {
    background-color: var(--neutro-claro);
    border-radius: 50%;
    font-size: 2rem;
    color: var(--verde-sicredi);
    aspect-ratio: 1 / 1;
    margin: 5px;
    width: 50px;
    display: grid;
    place-content: center;
}

.button__content {
    margin: 5px;

    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.button__title,
.button__subtitle {
    margin: 0;
}

.button__title {
    font-family: "Exo 2", "Arial", sans-serif;
    color: var(--verde-sicredi);
    font-weight: 400;
}

.button__subtitle {
    font-family: "Nunito", "Calibri", sans-serif;
    color: var(--neutro-escuro);
}

.button--disabled {
    background-color: var(--cinza);
    color: var(--neutro-escuro);
    box-shadow: 0 0 10px var(--cinza);
    cursor: not-allowed;
}

.button--disabled:hover {
    transform: scale(1);
}

.button__icon {
    font-size: 100%;
}

.button__icon--disabled {
    color: var(--cinza);
    background-color: var(--neutro-escuro);
}

.button__title--disabled {
    color: var(--neutro-escuro);
}
</style>
