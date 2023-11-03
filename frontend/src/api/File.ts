import apiClient from "./Index";

export default {
    upload: (formData: FormData) => {
        return apiClient.post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data", // É importante definir o cabeçalho 'Content-Type' corretamente para FormData
            }
        });
    }
};