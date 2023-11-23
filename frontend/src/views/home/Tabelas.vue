<template>
  <div class="container__tabelas">
    <p>Data com maior e menor Quantidade de movimentações</p>
    <v-table>
      <thead>
        <tr>
          <th class="text-left">
            Menor
          </th>
          <th class="text-left">
            Maior
          </th>
        </tr>
      </thead>
      <tbody>
        <!-- <tr>
            <td>{{ dados[0].menor._id }}</td>
            <td>{{ dados[0].menor.count }}</td>
        </tr>
        <tr>
          <td>{{ dados[0].maior._id }}</td>
          <td>{{ dados[0].maior.count }}</td>
        </tr> -->
        <tr>
          <td>ads</td>
          <td>cdca</td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";

// Data com maior e menor Quantidade de movimentações
const dados: number[] = [];
const dias: string[] = [];
const valores: number[] = [];

await MetricsApi.DataMaiorMenorQtdMov().then((res => {
    dados.push(res.data[0]);
    dias.push(dados[0].menor._id);
    dias.push(dados[0].maior._id);

    valores.push(dados[0].menor.count);
    valores.push(dados[0].maior.count);
}));
</script>