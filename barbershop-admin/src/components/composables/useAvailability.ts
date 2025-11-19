import { ref, computed } from "vue";
import { axiosInstance } from "@/helpers/helper";
import type { AvailableDateTimesInterface } from "@/helpers/types";

export function useAvailability() {
    
    const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);
 
    async function fetchAvailability() {
        try {
            const { data } = await axiosInstance.get("/api/v1/availabilities");
            availableDateTimes.value = data.data;
        } catch(error) {
            console.log(error);
        }
    }

    const onlyFreeDays = computed(() =>
        availableDateTimes.value.map(d => {
            const [y, m, day] = d.date.split("-").map(Number);
            return new Date(y, m - 1, day);
        })
    );

    return {
        availableDateTimes,
        onlyFreeDays,
        fetchAvailability,
    };
}
