import apiClient from "./Index";

export default {
    upload: (formData: FormData) => {
        return apiClient.post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data", // É importante definir o cabeçalho 'Content-Type' corretamente para FormData
            }
        });
    },
    upload1: (formData: FormData) => {
        return apiClient.post("/upload1", formData, {
            headers: {
                //"Content-Type": "application/octet-stream", // É importante definir o cabeçalho 'Content-Type' corretamente para FormData
                "Content-Type": "multipart/form-data", // É importante definir o cabeçalho 'Content-Type' corretamente para FormData

                // "Access-Control-Allow-Origin": "*",
                // "Access-Control-Allow-Methods": "GET,PUT,POST,DELETE,PATCH,OPTIONS"
            }
        });
    }
};