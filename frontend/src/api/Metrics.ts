import axios from "./Index";

export default {
    DataMaiorMenorQtdMov: () => {
        return axios.get("/DataMaiorMenorQtdMov");
    },
    DataMaiorMenorSomaMov: () => {
        return axios.get("/DataMaiorMenorSomaMov");
    },
    movPixDiaSemana: () => {
        return axios.get("/movPixDiaSemana");
    },
    qtdValorMovPorCoopAg: () => {
        return axios.get("/qtdValorMovPorCoopAg");
    },
    qtdValorMovPorCoopAgPrev: () => {
        return axios.get("/qtdValorMovPorCoopAgPrev");
    },
    credVsDebPorHora: () => {
        return axios.get("/credVsDebPorHora");
    },
};