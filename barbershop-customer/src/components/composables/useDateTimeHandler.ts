import { ref, type Ref } from "vue";

import type { AvailableDateTimesInterface } from "@/helpers/types";

export function useDateTimeHandler(selectedTime: Ref<string|undefined>) {

    const times = ref<String[]>([]);
    const isDisabled = ref<boolean>(true);

    const handleDate = (chosenDate: Date, availableDateTimes: AvailableDateTimesInterface[]) => {

        const fullDate = getFormattedDate(chosenDate);

        times.value = availableDateTimes.filter(dateTime => dateTime.date === fullDate).map(dateTime => dateTime.time);

        if (times.value.length > 0) {
            isDisabled.value = false;
        } else {
            isDisabled.value = true;
            selectedTime.value = "";
        }
    }

    const getFormattedDate = (date: Date) => {
        const newDate = new Date(date);
        const day = String(newDate.getDate()).padStart(2, '0');
        const month = String(newDate.getMonth() + 1).padStart(2, '0');
        const year = newDate.getFullYear();

        return `${year}-${month}-${day}`;
    }

    const format = (date: Date) => {
        return new Intl.DateTimeFormat('pt-BR').format(date);
    }

    const toLocalDate = (dateString: string) => {
        const [year, month, day] = dateString.split("-").map(Number);
        return new Date(year, month - 1, day);
    }

    return {
        isDisabled, handleDate, getFormattedDate, toLocalDate, format, times
    }
}