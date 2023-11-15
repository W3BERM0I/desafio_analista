import axios from "./Index";

export default {
    upload: (formData: FormData) => {
        return axios.post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data", // É importante definir o cabeçalho 'Content-Type' corretamente para FormData
            }
        });
    },
    startEnd: () => {
        return axios.get("/startEnd");
    },
};