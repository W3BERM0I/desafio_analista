<template>
  <v-app>
    <v-main>
      <PNavigation
        home-link="login"
        :sidebar-items="sidebarItems"
        :sidebar-user-items="sidebarUserItems"
      />
      <div
        class="main__dashbord"
      >
        <div class="container__dashbord">
          <cred-vs-deb-por-hora class="resultado__dashbord elevation-4" />
          <data-maior-menor-qtd-mov class="resultado__dashbord elevation-4" />
          <data-maior-menor-soma-mov class="resultado__dashbord elevation-4" />
          <mov-pix-dia-semana class="resultado__dashbord elevation-4" />
          <qtd-valor-mov-por-coop-ag class="resultado__dashbord elevation-4" />
          <acoes-componente class="resultado__dashbord elevation-4" />
        </div>
      </div>
    </v-main>
  </v-app>
</template>
    
<script lang="ts" setup>
import { useRouter } from "vue-router";
import { useUserStore } from "@/store/user";
import credVsDebPorHora from "./home/credVsDebPorHora.vue";
import DataMaiorMenorQtdMov from "./home/DataMaiorMenorQtdMov.vue";
import DataMaiorMenorSomaMov from "./home/DataMaiorMenorSomaMov.vue";
import movPixDiaSemana from "./home/movPixDiaSemana.vue";
import qtdValorMovPorCoopAg from "./home/QtdValorMovPorCoopAg.vue";
import AcoesComponente from "./home/AcoesComponente.vue";
    

const userStore = useUserStore();
const router = useRouter();
  
const sidebarItems = [
    {
        icon: "upload",
        text: "Adicionar novo arquivo",
        action: () => (alert("cheguei")),
    },
    {
        icon: "users",
        text: "Gerenciar Usuarios",
        action: () => {},
        children: [
            {
                icon: "check",
                text: "Adicionar usuario",
                action: () => (alert("cheguei")),
            },
            {
                icon: "xmark",
                text: "Excluir usuario",
                action: () => (alert("cheguei")),
            },
        ],
    },
];

const sidebarUserItems = [
    {
        icon: "right-from-bracket",
        text: "Sair",
        action: async () => {
            try {
                // await loginApi.logout();
                userStore.unsetUserData();
                router.push({ name: "Login" });
            } catch (error) {
                //
            }
        },
    },
];
</script>
    
<style>
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
</style>