<template>
  <PNavigation
    home-link="login"
    :sidebar-items="sidebarItems"
    :sidebar-user-items="sidebarUserItems"
  />

  <add-user :flag="AddUserUserFlag" />
</template>

<script lang="ts" setup>
import { useRouter } from "vue-router";
import { useUserStore } from "@/store/user";
import Auth from "@/api/Auth";
import AddUser from "../admin/AddUser.vue";
import { ref } from "vue";

const userStore = useUserStore();
const router = useRouter();

const AddUserUserFlag = ref(false);

const sidebarItems = [
    {
        icon: "upload",
        text: "Adicionar novo arquivo",
        action: () => (alert("cheguei")),
    },
];

if(!userStore.user.admin) {
    sidebarItems.push(
        {
            icon: "users",
            text: "Gerenciar Usuarios",
            action: () => {},
            children: [
                {
                    icon: "check",
                    text: "Adicionar usuario",
                    action: () => (AddUserUserFlag.value = true),
                },
                {
                    icon: "xmark",
                    text: "Excluir usuario",
                    action: () => (alert("cheguei")),
                },
            ],
        },);
}

const sidebarUserItems = [
    {
        icon: "right-from-bracket",
        text: "Sair",
        action: async () => {
            await Auth.logout().then((res => {
                userStore.unsetUserData();
                router.push({ name: "Login" });
            })).catch((err => {
                console.log(err);
            }));
        },
    },
];
</script>