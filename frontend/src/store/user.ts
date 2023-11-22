// Utilities
import { defineStore } from "pinia";
import { Ref, ref } from "vue";

import type { UserData } from "@/types";

export const useUserStore = defineStore("user", () => {
    //state
    const user: Ref<UserData> = ref(
        localStorage.getItem("user")
            ? JSON.parse(localStorage.getItem("user") as string)
            : { email: "", token: "", admin: ""}
    ) as Ref<UserData>;
    
    function setUserData(value: UserData) {
        setUserStore(value.email, value.token, value.admin);

        localStorage.setItem("user", JSON.stringify(user.value));
    }

    function unsetUserData() {
        localStorage.removeItem("user");
        setUserStore("", "", false);
    }

    function setUserStore(email: string, token: string, admin: boolean)
    {
        user.value.email = email;
        user.value.token = token;
        user.value.admin = admin;
    }

    function getToken()
    {
        return user.value.token;
    }

    return {
        user,
        setUserData,
        unsetUserData,
        getToken
    };
});
