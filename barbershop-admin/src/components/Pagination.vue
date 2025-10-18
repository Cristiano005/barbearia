<template>
    <nav aria-label="...">
        <ul class="pagination justify-content-center">
            <template v-if="pagination.currentPage > 1">
                <li class="page-item">
                    <button class="page-link" @click="$emit('goToPage', pagination.currentPage - 1)">Previous</button>
                </li>
            </template>
            <template v-else>
                <li class="page-item disabled">
                    <button class="page-link">Previous</button>
                </li>
            </template>

            <li :class="pagination.currentPage === page ? 'active' : ''" v-for="page of pagination.quantityOfPages">
                <button class="page-link" @click="$emit('goToPage', page)">
                    {{ page }}
                </button>
            </li>

            <template v-if="pagination.currentPage < pagination.quantityOfPages">
                <li class="page-item">
                    <button class="page-link" @click="$emit('goToPage', pagination.currentPage + 1)">Next</button>
                </li>
            </template>
            <template v-else>
                <li class="page-item disabled">
                    <button class="page-link">Next</button>
                </li>
            </template>
        </ul>
    </nav>
</template>

<script setup lang="ts">

import type { PropType } from 'vue';

import type { PaginationInterface } from '@/helpers/types';

const props = defineProps({
    pagination: {
        type: Object as PropType<PaginationInterface>,
        required: true,
    }
});

const emits = defineEmits<{
    (e: "goToPage", page: number): void
}>();

</script>