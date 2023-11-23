import axios from "./Index";

export default {
    login: (email: string, password: string) => {
        return axios.post("/login", {
            email,
            password
        });
    },
    logout: () => {
        return axios.get("/logout");
    },
    createUser: (email: string, password: string) => {
        return axios.post("/createUser", {
            email,
            password
        });
    },
};