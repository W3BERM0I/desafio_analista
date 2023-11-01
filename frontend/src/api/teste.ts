import apiClient from "./Index";

export default {
    test: () => {
        return apiClient.get("/teste");
    }
};