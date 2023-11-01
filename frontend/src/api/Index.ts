import axios from "axios";

const apiClient = axios.create({
    baseURL: "http://localhost:3080/api/",
    headers: {
        "Accept": "application/json",
        "Content": "application/json"
    }
});

export default apiClient;