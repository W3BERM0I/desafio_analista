<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";

onMounted(async () => {
    const mov: any[] = [];
    await MetricsApi.qtdValorMovPorCoopAg().then((res => {
        const dados: any[] = res.data[0];
        // console.log(dados);

        // dados.forEach(el => {
        //     mov.push(el.count);
        // });
    }));

    const labels = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June"
    ];

    const data = {
        labels: labels,
        datasets: [{
            label: "Quantidade de valor movimentado por coop/ag",
            backgroundColor: "rgb(255, 99, 132)",
            borderColor: "rgb(255, 99, 132)",
            data: [0, 10, 5, 2, 20, 30, 45]
        }]
    };

    const config = {
        type: "line",
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById("grafico5"),
        config
    );
});
</script>

<template>
  <div>
    <canvas id="grafico5" />
  </div>
</template>