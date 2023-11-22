<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";

onMounted( async () => { 
    const dados: number[] = [];
    const dias: string[] = [];
    const valores: number = [];

    await MetricsApi.DataMaiorMenorSomaMov().then((res => {
        dados.push(res.data[0]);
        dias.push(dados[0].menor._id);
        dias.push(dados[0].maior._id);

        valores.push(dados[0].menor.somaMov);
        valores.push(dados[0].maior.somaMov);
    }));

    const data = {
        labels: dias,
        datasets: [{
            label: "",
            backgroundColor: ["#5a645a", "#3fa110"],
            data: [...valores]
        }],
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
            layout: {
            },

            plugins: {
                title: {
                    display: true,
                    text: "Data com maior e menor soma de movimentações"
                }
            },
        },
    };

    const myChart = new Chart(
        document.getElementById("grafico3"),
        config
    );
});
</script>

<template>
  <div>
    <canvas id="grafico3" />
  </div>
</template>