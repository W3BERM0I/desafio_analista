<template>
  <v-app>
    <v-main>
      <nav-bar />
      <div
        class="main__dashbord"
      >
        <div 
          class="switch__layout"
        >
          <v-switch
            v-model="layout"
            label="Alterar layout"
          />
        </div>
        <div v-if="!layout">
          <div
            v-if="status"
            class="container__dashbord"
          >
            <cred-vs-deb-por-hora class="resultado__dashbord elevation-4" />
            <data-maior-menor-qtd-mov class="resultado__dashbord elevation-4" />
            <data-maior-menor-soma-mov class="resultado__dashbord elevation-4" />
            <mov-pix-dia-semana class="resultado__dashbord elevation-4" />
            <qtd-valor-mov-por-coop-ag class="resultado__dashbord elevation-4" />
            <acoes-componente class="resultado__dashbord elevation-4" />
          </div>
          <div 
            v-else
            class="container__dashbord1"
          >
            <acoes-componente class="resultado__dashbord elevation-4" />
            <v-btn
              style="margin-top: 40px; margin-left: 30px;"
              @click="reload"
            >
              atualizar pagina a upload do arquivo
            </v-btn>
          </div>
        </div>
        <tabelas v-else />
      </div>
    </v-main>
  </v-app>
</template>
    
<script lang="ts" setup>
import credVsDebPorHora from "./home/credVsDebPorHora.vue";
import DataMaiorMenorQtdMov from "./home/DataMaiorMenorQtdMov.vue";
import DataMaiorMenorSomaMov from "./home/DataMaiorMenorSomaMov.vue";
import movPixDiaSemana from "./home/movPixDiaSemana.vue";
import qtdValorMovPorCoopAg from "./home/QtdValorMovPorCoopAg.vue";
import AcoesComponente from "./home/AcoesComponente.vue";
import NavBar from "@/components/shared/NavBar.vue";  
import { onMounted, ref } from "vue";
import FileApi from "@/api/File";
import Tabelas from "./home/Tabelas.vue";

const status = ref(null);
const layout = ref(false);

const reload = () => {
    location.reload();
};

onMounted(async () => { 
    const res = await FileApi.verifyBase();
    status.value = res.data.status;

});

</script>
    
<style>
.switch__layout {
  margin-top: 20px;
  margin-bottom: 0;
}

.main__dashbord {
    display: grid;
    height: 85vh; /* 100% da altura da viewport (janela do navegador) */
    place-items: center;
    margin: 0;
}

.container__dashbord {
    margin: 0;
    display: grid;
    grid-template-rows: 1fr 1fr; /* Duas linhas igualmente divididas */
    grid-template-columns: 1fr 1fr 1fr; /* Três colunas igualmente divididas */
    grid-gap: 10px;
    height: 70vh; /* Ocupar a altura total da viewport */
    width: 95vw;
}

.resultado__dashbord {
    padding: 10px;
    /* margin-top: 40px; */
    border-radius: 20px;
    box-shadow: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.resultado__dashbord1 {
  margin: 0;
  height: 100vh; /* Isso garante que o contêiner ocupe toda a altura da tela. */
  display: grid;
  place-items: center;
}

</style>