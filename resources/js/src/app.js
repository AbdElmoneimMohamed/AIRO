import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";
import axios from "axios";

const app = createApp(App);
const pinia = createPinia();

axios.defaults.baseURL = "http://localhost/api";

const token = localStorage.getItem("token");

if (token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

app.use(router).use(pinia).mount("#app");
