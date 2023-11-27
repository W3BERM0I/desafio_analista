<template>
  <PNavigation
    home-link="login"
    :sidebar-items="sidebarItems"
    :sidebar-user-items="sidebarUserItems"
  />

  <v-row justify="center">
    <v-dialog
      v-model="dialogAddUser"
      persistent
      width="1024"
    >
      <add-user 
        @close="dialogAddUser = false"
      />
    </v-dialog>
    <v-dialog
      v-model="dialogDeleteUser"
      scrollable
      width="auto"
    >
      <delete-user 
        @close="dialogDeleteUser = false"
      />
    </v-dialog>
  </v-row>
</template>

<script lang="ts" setup>
import { useRouter } from "vue-router";
import { useUserStore } from "@/store/user";
import Auth from "@/api/Auth";
import AddUser from "@/views/admin/AddUser.vue";
import DeleteUser from "@/views/admin/DeleteUser.vue";
import { ref } from "vue";

const userStore = useUserStore();
const router = useRouter();

const dialogDeleteUser = ref(false);
const dialogAddUser = ref(false);
const emits = defineEmits(["status"]);

const sidebarItems = [
    {
        icon: "upload",
        text: "Adicionar novo arquivo",
        action: () => (emits("status")),
    },
];

if(userStore.user.admin) {
    sidebarItems.push(
        {
            icon: "users",
            text: "Gerenciar Usuarios",
            action: () => {},
            children: [
                {
                    icon: "check",
                    text: "Adicionar usuario",
                    action: () => (dialogAddUser.value = true),
                },
                {
                    icon: "xmark",
                    text: "Excluir usuario",
                    action: () => (dialogDeleteUser.value = true),
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