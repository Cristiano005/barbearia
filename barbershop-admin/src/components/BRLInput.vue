<template>
    <input type="text" class="form-control" :placeholder="placeholder" ref="inputRef" />
</template>

<script setup lang="ts">

import { onMounted, watch } from "vue";
import { useCurrencyInput, type CurrencyInputOptions } from "vue-currency-input";

const props = defineProps<{
    modelValue: number | null,
    options: CurrencyInputOptions,
    placeholder: string,
}>();

const emit = defineEmits(["update:modelValue", "change"]);
const { inputRef, setValue } = useCurrencyInput(props.options);


onMounted(() => {
    if (props.modelValue === null && inputRef.value) inputRef.value.value = "";
});


watch(
    () => props.modelValue,
    (value, old) => {

        if (value === old) return;

        if (value === null) {
            if (inputRef.value) inputRef.value.value = "";
            return;
        }

        const n = typeof value === "number" ? value : Number(value);

        if (!Number.isNaN(n)) setValue(n);
        else { 
            if (inputRef.value) inputRef.value.value = ""; 
        }
    },
    { immediate: false }
);

</script>