<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";

const labels = [
    "00:00",
    "01:00",
    "02:00",
    "03:00",
    "04:00",
    "05:00",
    "06:00",
    "07:00",
    "08:00",
    "09:00",
    "10:00",
    "11:00",
    "12:00",
    "13:00",
    "14:00",
    "15:00",
    "16:00",
    "17:00",
    "18:00",
    "19:00",
    "20:00",
    "21:00",
    "22:00",
    "23:00",
];

const data = {
    labels: labels,
    datasets: [{
        label: "Credito vs debito por hora",
        backgroundColor: "rgb(255, 99, 132)",
        borderColor: "rgb(255, 99, 132)",
        data: [0, 10, 5, 2, 20, 30, 45, 30, 40, 15, 0, 10, 5, 2, 20, 30, 45, 30, 40, 15, 45, 30, 40, 15]
    }, 
    {
        label: "Credito vs debito por hora",
        backgroundColor: "rgb(255, 53, 32)",
        borderColor: "rgb(255, 53, 32)",
        data: [0, 15, 5, 2, 28, 70, 35, 30, 40, 15, 0, 34, 5, 20, 20, 30, 35, 30, 40, 15, 45, 30, 40, 15]
    }]
};

const config = {
    type: "line",
    data: data,
    options: {}
};

onMounted(() => { 
    const myChart = new Chart(
        document.getElementById("grafico1"),
        config
    );
});
</script>

<template>
  <div>
    <canvas id="grafico1" />
  </div>
</template>