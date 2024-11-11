import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { axiosInstance } from '@/helpers/helper';

export const useUserStore = defineStore('user', () => {

  const isAuthenticated = ref<boolean>(false);

  async function check() {

    try {
      const { data } = await axiosInstance.get("/api/v1/auth/check");
      isAuthenticated.value = data;
    } catch (error) {
        console.log(error)
    }

  }

  return { isAuthenticated, check }
});