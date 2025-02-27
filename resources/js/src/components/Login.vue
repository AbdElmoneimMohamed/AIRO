<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-white-900">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-black mb-6">Login</h2>

            <form @submit.prevent="handleLogin" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-black">Email</label>
                    <input
                        v-model="email"
                        type="email"
                        id="email"
                        placeholder="name@company.com"
                        required
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm  dark:text-black dark:border-gray-300"
                    />
                    <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</p>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-black">Password</label>
                    <input
                        v-model="password"
                        type="password"
                        id="password"
                        placeholder="••••••••"
                        required
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm  dark:text-black dark:border-gray-300"
                    />
                    <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { useAuthStore } from "../store/auth";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
    setup() {
        const email = ref("");
        const password = ref("");
        const errors = ref({});
        const authStore = useAuthStore();
        const router = useRouter();

        const handleLogin = async () => {
            errors.value = {};

            try {
                const response = await authStore.login({ email: email.value, password: password.value });
                if (response.success) {
                    router.push("/quotation");
                }
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    errors.value = error.response.data.errors;
                } else {
                    errors.value.password = error.response.data.message;
                }
            }
        };

        return { email, password, handleLogin, errors };
    },
};
</script>
