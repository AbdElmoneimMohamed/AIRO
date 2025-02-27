import { createRouter, createWebHistory } from "vue-router";
import Login from "./components/Login.vue";
import QuotationForm from "./components/QuotationForm.vue";

const routes = [
    { path: "/", component: Login },
    { path: "/quotation", component: QuotationForm, meta: { requiresAuth: true } }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");
    if (to.meta.requiresAuth && !token) {
        next("/");
    } else {
        next();
    }
});

export default router;
