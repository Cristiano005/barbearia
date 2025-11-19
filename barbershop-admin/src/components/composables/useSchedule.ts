import { reactive, ref } from "vue";

import { axiosInstance } from "@/helpers/helper";
import type { PaginationInterface, ScheduleInterface } from "@/helpers/types";

export function useSchedule() {

    const schedules = ref<ScheduleInterface[]>([]);

    const pagination = reactive<PaginationInterface>({
        quantityOfPages: 1,
        currentPage: 1,
    });

    async function getSchedules(selectedStatusFilter: string) {

        try {
            const statusFilter = selectedStatusFilter.toLowerCase();
            const { data } = await axiosInstance.get(`api/v1/admin/schedules?status=${statusFilter}&page=${pagination.currentPage}`);
            pagination.quantityOfPages = data.meta.last_page;
            schedules.value = data.data;
        }

        catch (error) {
            console.log(error);
        }
    }

    async function updateStatus(scheduleId: number, status: "success" | "absent") {

        try {

            const { data } = await axiosInstance.patch(`/api/v1/admin/schedules/${scheduleId}/status`, {
                status: status
            });

            return data.success;
        }

        catch (error) {
            console.log(error);
        }

    }

    return {
        schedules, pagination, getSchedules, updateStatus
    }
}