<script setup lang="ts">
import Chart from "chart.js/auto";
import { onMounted } from "vue";
import MetricsApi from "@/api/Metrics";

onMounted( async () => { 
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

    const credito: number[] = [];
    const debito: number[] = [];
    
    await MetricsApi.credVsDebPorHora().then((res => {
        const dados: any[] = res.data[0];
        dados.forEach(el => {
            credito.push(el.totalCredito);
            debito.push(el.totalDebito);
        });
    }));


    const data = {
        labels: labels,
        datasets: [{
            label: "Credito",
            backgroundColor: "rgb(255, 99, 132)",
            borderColor: "rgb(255, 99, 132)",
            data: credito
        }, 
        {
            label: "debito",
            backgroundColor: "rgb(255, 53, 32)",
            borderColor: "rgb(255, 53, 32)",
            data: debito
        }]
    };

    const config = {
        type: "line",
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Relação de créditos x débitos ao longo das horas do dia"
                }
            },
        },
    };

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