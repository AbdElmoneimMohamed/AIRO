import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null,
    }),

    actions: {
        async login(credentials) {
            try {
                const response = await axios.post("/login", credentials);
                this.token = response.data.data.token;

                localStorage.setItem("token", this.token);
                axios.defaults.headers.common["Authorization"] = `Bearer ${this.token}`;
                return { success: true };
            } catch (error) {
                throw error;
            }
        },

        async logout() {
            this.token = null;
            localStorage.removeItem("token");
            delete axios.defaults.headers.common["Authorization"];
        },
    },
});
