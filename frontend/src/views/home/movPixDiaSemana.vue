<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";
import { onBeforeMount } from "vue";

onMounted(async () => { 
    const mov: number[] = [];
    await MetricsApi.movPixDiaSemana().then((res => {
        const dados: any[] = res.data[0];
        dados.forEach(el => {
            mov.push(el.count);
        });
    }));

    const labels = [
        "Domingo",
        "Segunda",
        "Terça",
        "Quarta",
        "Quinta",
        "Sexta",
        "Sabado",
    ];

    const data = {
        labels: [
            "Domingo",
            "Segunda",
            "Terça",
            "Quarta",
            "Quinta",
            "Sexta",
            "Sabado",
        ],
        datasets: [{
            label: labels,
            data: mov,
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
            },
            plugins: {
                title: {
                    display: true,
                    text: "Dia da semana em que houveram mais movimentações dos tipos (código de movimentação) “RX1” e “PX1”"
                }
            },
        },
    };

    // const config = {
    //   type: 'doughnut',
    //   data: data,
    // };



    const myChart = new Chart(
        document.getElementById("grafico4"),
        config
    );
});
</script>

<template>
  <div>
    <canvas
      id="grafico4"
    />
  </div>
</template>