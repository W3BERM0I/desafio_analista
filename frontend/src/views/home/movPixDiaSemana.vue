<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";
import { onBeforeMount } from "vue";

onMounted(async () => { 
    const PX1: number[] = [];
    const RX1: number[] = [];
    await MetricsApi.movPixDiaSemana().then((res => {
        const dados: any[] = res.data[0];

        dados.px1.forEach(el => {
            PX1.push(el.count);
        });

        dados.rx1.forEach(el => {
            RX1.push(el.count);
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
        labels: labels,
        datasets: [{
            label: "RX1",
            backgroundColor: "#ffcd00",
            borderColor: "#ffcd00",
            data: RX1
        }, 
        {
            label: "PX1",
            backgroundColor: "#5a645a)",
            borderColor: "#5a645a",
            data: PX1
        }]
    };

    const config = {
        type: "line",
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Dia da semana em que houveram mais movimentações dos tipos “RX1” e “PX1”"
                }
            },
        },
    };

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