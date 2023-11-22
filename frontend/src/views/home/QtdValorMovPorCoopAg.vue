<script setup lang="ts">
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";
import { reactive } from "vue";

const dados = reactive([]);
onMounted(async () => {
    await MetricsApi.qtdValorMovPorCoopAgPrev().then((res => {
        dados.push(...res.data[0]);
    }));
});
</script>

<template>
  <div class="container__ag">
    <!-- <canvas id="grafico5" /> -->
    <p>4 agencias que mais tiveram soma de movimentações</p>
    <div class="container__dados">
      <div
        v-for="(dado, index) in dados"
        :key="index"
      >
        <p>coop/ag: {{ dado._id }}</p>
        <p>soma: {{ dado.somaMov }}</p>
        <p>quantidade: {{ dado.quantidade }}</p>
      </div>
    </div>
  </div>
</template>

<style>
.container__ag {
  display: flex;
  flex-direction: column;
  max-width: 100%;
  max-height: 100%;
}

.container__dados {
  display: grid;
  grid-template-rows: 1fr 1fr; /* Duas linhas igualmente divididas */
  grid-template-columns: 1fr 1fr; /* Três colunas igualmente divididas */
  grid-gap: 10px;

  max-width: 95%;
  max-height: 95%;
}
</style>