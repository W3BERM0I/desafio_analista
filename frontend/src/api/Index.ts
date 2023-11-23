import axios from "axios";
import type {
    AxiosError,
    AxiosResponse,
} from "axios";

import { useUserStore } from "@/store/user";
import { useRouter } from "vue-router";

const apiClient = axios.create({
    baseURL: "http://localhost:3080/api/",
    headers: {
        "Accept": "application/json",
        "Content": "application/json"
    }
});

apiClient.interceptors.request.use((config: any) => {
    const userStore = useUserStore();
    const token = userStore.getToken();

    if(token)
        config.headers["Authorization"] = `Bearer ${token}`;

    return config;
});

// Interceptor de resposta
apiClient.interceptors.response.use(
    (response: AxiosResponse) => {
        // Faça algo com a resposta bem-sucedida
        return response;
    },
    (error: AxiosError) => {
        // Lidar com erros de resposta, como tokens expirados
        if (error.response?.status === 401) {
            const router = useRouter();
            // Faça o que for necessário, como redirecionar para a página de login
            console.error("Token expirado ou inválido. Redirecionando para a página de login.");
            router.push({name: "Login"});

        }
        return Promise.reject(error);
    }
);

export default apiClient;