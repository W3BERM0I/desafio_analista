import axios from "./Index";

export default {
    createUser: (email: string, password: string) => {
        return axios.post("/createUser", {
            email,
            password
        });
    },
    deleteUser: (email: string) => {
        return axios.post("/deleteUser", {
            email
        });
    },
    allCommonUser: () => {
        return axios.get("/allCommonUser");
    },
};