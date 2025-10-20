<template>
    <input type="text" class="form-control" :placeholder="placeholder" ref="inputRef" />
</template>

<script setup lang="ts">

import { watch } from "vue";
import { useCurrencyInput, type CurrencyInputOptions } from "vue-currency-input";

const props = defineProps<{
    modelValue: number | null,
    options: CurrencyInputOptions,
    placeholder: string,
}>();

const emit = defineEmits(["update:modelValue", "change"]);
const { inputRef, setValue } = useCurrencyInput(props.options);

watch(() => props.modelValue, (value) => { setValue(value) }, { immediate: true });

</script>