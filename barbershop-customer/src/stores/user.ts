import { ref } from "vue"
import { defineStore } from "pinia"
import { axiosInstance } from "@/helpers/helper";
import { useRouter } from "vue-router";
import type { ProfileDataInterface } from "@/helpers/types";

export const useUserStore = defineStore("user", () => {

    const router = useRouter();

    const user = ref<ProfileDataInterface | null>(null);
    const isAuthenticated = ref<boolean>(false);

    async function authenticate(email: string, password: string) {

        try {

            await axiosInstance.get("/sanctum/csrf-cookie");

            const { data } = await axiosInstance.post("/api/v1/auth/authenticate", {
                email: email,
                password: password,
            });

            if (data.success === true) {
                isAuthenticated.value = true;
                user.value = await refreshUser();
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

    async function register(name: string, email: string, password: string) {

        try {
            await axiosInstance.get("/sanctum/csrf-cookie");

            const { data } = await axiosInstance.post("/api/v1/auth/register", {
                name: name,
                email: email,
                password: password
            });

            if (data.success === true) {
                isAuthenticated.value = true;
                user.value = await refreshUser();
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

    async function update(fullname: string, phone_number: string) {

        try {

            const { data } = await axiosInstance.put(`/api/v1/user/update`, {
                name: fullname,
                phone_number: phone_number
            });

            return data;
        }

        catch (error) {
            console.log(error);
        }
    }

    async function refreshUser() {

        try {
            const { data } = await axiosInstance.get("/api/v1/user/me");
            const userData = {
                name: data.data.name,
                email: data.data.email,
                phone_number: data.data.phone_number,
                has_pending_schedule: data.data.has_pending_schedule,
            };
            return userData;
        }

        catch (error) {
            console.log(error);
            return null;
        }
    }

    async function check() {

        try {

            const { data } = await axiosInstance.get("/api/v1/auth/check", { withCredentials: true });

            isAuthenticated.value = data.authenticated;

            if (isAuthenticated.value)  user.value = await refreshUser();
            else user.value = null;

        } catch (error) {
            console.log(error)
        }
    };

    async function logout() {
        try {
            await axiosInstance.post("/api/v1/auth/logout", {}, { withCredentials: true });
            isAuthenticated.value = false;
            user.value = null;
            router.push({ name: "signin" });
        } catch (error) {
            console.log(error)
        }
    };

    return { isAuthenticated, user, authenticate, register, update, refreshUser, check, logout }
}, {
    persist: {
        storage: sessionStorage,
        paths: ["isAuthenticated", "user"],
    },
},);