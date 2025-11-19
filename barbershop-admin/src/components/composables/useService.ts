import { reactive, ref } from "vue";

import { fetchServices } from "@/services/serviceService";
import type { FetchServicesParams, PaginationInterface, ServiceInterface } from "@/helpers/types";

export function useService() {

    const services = ref<ServiceInterface[]>([]);

    const pagination = reactive<PaginationInterface>({
        quantityOfPages: 1,
        currentPage: 1,
    });

    async function getServices({ currentPage = 1, all = false }: FetchServicesParams) {

        try {

            const data = await fetchServices({ currentPage, all });

            if (!all && data.meta) {
                pagination.quantityOfPages = data.meta.last_page;
                pagination.currentPage = data.meta.current_page;
            }

            services.value = data;
        }

        catch (error) {
            console.log(error);
        }
    }

    return {
        services, pagination, getServices
    }
}
