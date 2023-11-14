<template>
    <a :href="href" class="contact" target="_blank">
        <v-icon class="contact__icon contact__icon--size" :icon="icon" />
        <div class="contact__details">
            <h3 class="contact__title">{{ title }}</h3>
            <p class="contact__subtitle">{{ text }}</p>
        </div>
    </a>
</template>

<script setup lang="ts">
defineProps({
    href: {
        type: String,
        required: false,
    },
    icon: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    text: {
        type: String,
        required: true,
    },
});
</script>

<style scoped>
.contact {
    display: flex;
    text-decoration: none;
}

.contact__icon {
    color: var(--verde-sicredi);
    font-size: 3rem;

    width: 80px;

    text-align: right;
}

.contact__icon--size {
    font-size: 250%;
    padding-right: 15px;
}

.contact__qrcode {
    height: 3rem;
    width: 80px;
}
.contact__details > * {
    font-family: "Nunito", "Arial", sans-serif;
    font-weight: 200;

    text-align: left;

    width: 160px;
}
.contact__title {
    color: var(--verde-escuro);
}

.contact__subtitle {
    color: var(--neutro-escuro);
}
</style>
