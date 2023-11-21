import axios from "./Index";

export default {
    login: (email: string, password: string) => {
        return axios.post("/login", {
            email,
            password
        });
    },
    createUser: (email: string, password: string) => {
        return axios.post("/createUser", {
            email,
            password
        });
    },
};