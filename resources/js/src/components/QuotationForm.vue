<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 ">
        <div class="w-full max-w-md bg-white dark:bg-white-900 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-black mb-6">Get a Quotation</h2>

            <form @submit.prevent="fetchQuotation" class="space-y-6">
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 dark:text-black">Age (comma separated)</label>
                    <input
                        v-model="age"
                        id="age"
                        type="text"
                        placeholder="28,35"
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-white-700 dark:text-black dark:border-gray-300"
                    />
                    <p v-if="errors.age" class="text-red-500 text-sm mt-1">{{ errors.age[0] }}</p>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-black">Start Date</label>
                    <input
                        v-model="start_date"
                        id="start_date"
                        type="date"
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-white-700 dark:text-black dark:border-gray-300"
                    />
                    <p v-if="errors.start_date" class="text-red-500 text-sm mt-1">{{ errors.start_date[0] }}</p>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-black">End Date</label>
                    <input
                        v-model="end_date"
                        id="end_date"
                        type="date"
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-white-700 dark:text-black dark:border-gray-300"
                    />
                    <p v-if="errors.end_date" class="text-red-500 text-sm mt-1">{{ errors.end_date[0] }}</p>
                </div>

                <div>
                    <label for="currency_id" class="block text-sm font-medium text-gray-700 dark:text-black">Currency</label>
                    <select
                        v-model="currency_id"
                        id="currency_id"
                        class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-white-700 dark:text-black dark:border-gray-300"
                    >
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                    </select>
                    <p v-if="errors.currency_id" class="text-red-500 text-sm mt-1">{{ errors.currency_id[0] }}</p>
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                        Get Quote
                    </button>
                    <button @click="logout" type="button" class="w-full ml-3 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-lg transition">
                        Logout
                    </button>
                </div>
            </form>

            <div v-if="quote" class="mt-6 p-4 bg-gray-100 dark:bg-white-700 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 dark:text-black">Total: {{ quote.total }} {{ quote.currency_id }}</p>
                <p class="text-sm text-gray-600 dark:text-black">Quotation ID: {{ quote.quotation_id }}</p>
            </div>

            <p v-if="errors.general" class="text-red-500 text-sm mt-3 text-center">{{ errors.general }}</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { useAuthStore } from "../store/auth";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
    setup() {
        const age = ref("");
        const start_date = ref("");
        const end_date = ref("");
        const currency_id = ref("EUR");
        const quote = ref(null);
        const errors = ref({});
        const authStore = useAuthStore();
        const router = useRouter();

        const fetchQuotation = async () => {
            errors.value = {};

            try {
                const response = await axios.post(
                    "/quotation",
                    {
                        age: age.value,
                        start_date: start_date.value,
                        end_date: end_date.value,
                        currency_id: currency_id.value,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                        },
                    }
                );
                quote.value = response.data.data;
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    errors.value = error.response.data.errors; // Capture validation errors
                } else {
                    errors.value.general = "An unexpected error occurred. Please try again.";
                }
            }
        };

        const logout = () => {
            authStore.logout();
            router.push("/");
        };

        return { age, start_date, end_date, currency_id, quote, fetchQuotation, logout, errors };
    },
};
</script>
