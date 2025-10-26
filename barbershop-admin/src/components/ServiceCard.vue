<template>
    <div class="row align-items-center text-bg-dark p-3 rounded m-0">
        <div class="col-auto">
            <i class="bi bi-scissors fs-1"></i>
        </div>
        <div class="col-10 border-end">
            <h6>
                {{ service.name }}
            </h6>
            <small>
                {{ formatCurrency(parseFloat(service.price)) }}
            </small>
        </div>
        <div class="d-flex col-auto gap-4 ps-5">
            <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
                @click="$emit('edit', service)"></i>
            <i class="fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"
                @click="$emit('cancel', service.id)"></i>
        </div>
    </div>
</template>

<script setup lang="ts">

import { type PropType } from "vue";

import type { ServiceInterface } from "@/helpers/types";
import { formatCurrency } from "@/helpers/helper";

const props = defineProps({
    service: {
        type: Object as PropType<ServiceInterface>,
        required: true,
    }
});

const emits = defineEmits<{
    (e: "edit", service: ServiceInterface): void
    (e: "cancel", serviceId: number): void
}>();

</script>