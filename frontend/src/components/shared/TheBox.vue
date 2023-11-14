<template>
  <div class="box__container">
    <div class="box__header">
      <h1 class="box__title">
        <slot name="title" />
      </h1>
      <p class="box__subtitle">
        <slot name="subtitle" />
      </p>
    </div>

    <div class="box__body">
      <slot name="body" />
    </div>
    <div class="box__footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<style scoped>
@import url("@/styles/shared/box.css");
</style>
