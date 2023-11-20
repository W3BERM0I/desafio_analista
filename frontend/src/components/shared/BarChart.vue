<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";

const labels = [
    "Segunda",
    "Terça",
    "Quarta",
    "Quinta",
    "Sexta",
    "Sabado",
    "Domingo"
];

const data = {
    labels: labels,
    datasets: [{
        label: "Dia da semana em que houveram mais movimentações dos tipos (código de movimentação) “RX1” e “PX1”",
        data: [65, 59, 80, 81, 56, 55, 40, 75],
        backgroundColor: [
            "rgba(255, 99, 132, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(75, 192, 192, 0.2)",
            "rgba(54, 162, 235, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(201, 203, 207, 0.2)",
            "rgba(201, 203, 207, 0.2)",
        ],
        borderColor: [
            "rgb(255, 99, 132)",
            "rgb(255, 159, 64)",
            "rgb(255, 205, 86)",
            "rgb(75, 192, 192)",
            "rgb(54, 162, 235)",
            "rgb(153, 102, 255)",
            "rgb(201, 203, 207)",
            "rgb(201, 203, 207)",
        ],
        borderWidth: 1
    }]
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
        }
    },
};

onMounted(() => { 
    const myChart = new Chart(
        document.getElementById("myChart"),
        config
    );
});
</script>

<template>
  <div
    class="container__class"
    height="100px"
    width="100px"
  >
    <!-- <h1>charts</h1> -->
    <canvas
      id="myChart"
    />
  </div>
</template>

<style>
/* .container__class {
    width: 100px;
    height: 100px;
} */
</style>