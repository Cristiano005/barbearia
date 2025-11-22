import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { axiosInstance } from '@/helpers/helper';
import { useRouter } from 'vue-router';

export const useUserStore = defineStore('user', () => {

    const isAuthenticated = ref<boolean>(false);
    const router = useRouter();

    const getAuthenticatedStatus = computed(() => isAuthenticated.value);

    async function authenticate(email: string, password: string) {

        try {

            await axiosInstance.get("/sanctum/csrf-cookie");

            const { data } = await axiosInstance.post("/api/v1/auth/authenticate", {
                email: email,
                password: password,
            });

            if (data.success === true) {
                isAuthenticated.value = true;
                router.push({ name: "profile" });
            }
        }

        catch (error: any) {
            throw {
                status: error.response?.status,
                message: error.response?.data?.message ?? "Unknown error"
            };
        }
    }

    async function check() {
        try {
            const { data } = await axiosInstance.get("/api/v1/auth/check", { withCredentials: true });
            isAuthenticated.value = data.authenticated;
        } catch (error) {
            console.log(error)
        }
    };

    async function logout() {
        try {
            await axiosInstance.post("/api/v1/auth/logout", {}, { withCredentials: true });
            isAuthenticated.value = false;
            router.push({ name: "signin" });
        } catch (error) {
            console.log(error)
        }
    };

    return { getAuthenticatedStatus, authenticate, check, logout }
});