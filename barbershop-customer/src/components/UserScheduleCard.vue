<template>
    <div class="row align-items-center text-bg-dark p-3 rounded">
        <div class="col-auto">
            <i class="bi bi-calendar-check fs-1"></i>
        </div>
        <div class="col-10 border-end">
            <h6>
                {{ schedule.date }} - {{ schedule.time }}
                <span :class="['badge', statusColors[schedule.status]]">
                    {{ schedule.status }}
                </span>
            </h6>
            <small>
                {{ schedule.service.name }} - {{ schedule.service.price }}
            </small>
        </div>
        <div class="d-flex col-auto gap-4 ps-5">
            <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
                @click="$emit('edit', schedule)"></i>
            <i class="fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"
                @click="$emit('cancel', schedule.id)"></i>
        </div>
    </div>
</template>

<script setup lang="ts">

import { reactive, type PropType } from "vue";

import type { ScheduleInterface, StatusColorsInterface } from "@/helpers/types";

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
    success: "text-bg-success",
    pending: "text-bg-warning",
    absent: "text-bg-secondary",
    cancelled: "text-bg-danger",
});

</script>

<style style="scss" scoped>

.cursor-pointer {
    cursor: pointer;
}

</style>