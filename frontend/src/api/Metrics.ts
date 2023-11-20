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
    credVsDebPorHora: () => {
        return axios.get("/movPixDiaSemana");
    },
};