<template>
    <div
        class="container"
        :class="{
            'container--no-padding': !padding,
        }"
    >
        <slot name="out"></slot>
        <div class="container__content">
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps({
    padding: {
        type: Boolean,
        default: true,
    },
});
</script>

<style scoped>
@import url("@/styles/shared/container.css");
.container__content:empty {
    display: none;
}
</style>
