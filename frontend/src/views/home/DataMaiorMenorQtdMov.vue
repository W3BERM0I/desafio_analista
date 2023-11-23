<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";

onMounted( async () => { 
    const dados: number[] = [];
    const dias: string[] = [];
    const valores: number = [];

    await MetricsApi.DataMaiorMenorQtdMov().then((res => {
        dados.push(res.data[0]);
        dias.push(dados[0].menor._id);
        dias.push(dados[0].maior._id);

        valores.push(dados[0].menor.count);
        valores.push(dados[0].maior.count);
    }));

    //label: "Data com maior e menor soma de movimentações",
    const data = {
        labels: dias,
        datasets: [{
            label: dias[0],
            backgroundColor: ["#5a645a", "#3fa110"],
            data: [...valores]
        },]
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: "Data com maior e menor Quantidade de movimentações"
                },
                legend: {
                    display: false
                },
            },
        },
    };

    const myChart = new Chart(
        document.getElementById("grafico2"),
        config
    );
});
</script>

<template>
  <div>
    <canvas id="grafico2" />
  </div>
</template>