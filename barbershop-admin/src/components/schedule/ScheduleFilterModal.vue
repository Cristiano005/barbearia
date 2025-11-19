<template>
    <div class="modal fade" id="scheduleFilterModal" tabindex="-1" aria-labelledby="serviceAddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceAddModalLabel">Filter Schedules</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Status</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="service-to-schedule" v-model="selectedStatusFilter">
                                <option v-for="filter of statusFilters">
                                    {{ filter }}
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" @click="$emit('applyFilters', selectedStatusFilter)">Filter</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import { computed, ref } from "vue";

const props = defineProps<{
    modelValue: String,
}>();
const emits = defineEmits(["applyFilters", "update:modelValue"]);

const selectedStatusFilter = computed({
    get: () => props.modelValue,
    set: (val) => emits("update:modelValue", val)
});

const statusFilters = ref<String[]>(["Success", "Pending", "Absent", "Cancelled"]);

</script>