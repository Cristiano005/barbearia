<template>
    <div class="d-flex align-items-center flex-wrap w-100 gap-4 gap-sm-0 text-bg-dark px-4 py-3 rounded">
        <div class="d-flex d-none d-sm-block col-sm-2 col-lg-1">
            <i :class="statusColors[schedule.status].icon" style="font-size: 3.5rem;"></i>
        </div>
        <div class="col-12 col-sm-6 col-md-7 col-lg-9">
            <h5>
                {{ schedule.user.name }}
            </h5>
            <h6>
                {{ schedule.date }} - {{ schedule.time }}
                <span :class="['badge', statusColors[schedule.status].color]">
                    {{ schedule.status }}
                </span>
            </h6>
            <small>
                {{ schedule.service.name }} - {{ formatCurrency(parseFloat(schedule.service.price)) }}
            </small>
        </div>
        <div class="col-12 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center gap-4">
            <div class="btn-group">
                <i class="d-flex align-items-center fs-4 bi bi-pencil-square cursor-pointer"
                    title="Define schedule's status" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item text-success" href="#">
                            <i class="bi bi-check"></i>
                            Success
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-secondary" href="#">
                            <i class="bi bi-person-fill-x"></i>
                            Absent
                        </a>
                    </li>
                </ul>
            </div> <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
                @click="$emit('edit', schedule)"></i>
            <i class=" fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"
                @click="$emit('cancel', schedule.id)"></i>
        </div>
    </div>
</template>

<script setup lang="ts">

import { reactive, type PropType } from "vue";

import type { ScheduleInterface, StatusColorsInterface } from "@/helpers/types";
import { formatCurrency } from "@/helpers/helper";

const props = defineProps({
    schedule: {
        type: Object as PropType<ScheduleInterface>,
        required: true,
    }
});

const emits = defineEmits<{
    (e: "edit", schedule: ScheduleInterface): void
    (e: "cancel", id: number): void
}>();

const statusColors = reactive<StatusColorsInterface>({

    success: {
        icon: "bi bi-calendar-check",
        color: "text-bg-success",
    },

    pending: {
        icon: "bi bi-calendar-event",
        color: "text-bg-warning",
    },

    absent: {
        icon: "bi bi-calendar-minus",
        color: "text-bg-secondary",
    },

    cancelled: {
        icon: "bi bi-calendar-x",
        color: "text-bg-danger",
    },
});

</script>