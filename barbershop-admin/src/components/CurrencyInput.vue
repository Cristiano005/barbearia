<template>
    <label :for="inputId" class="form-label">Price*</label>
    <input type="text" :class="['form-control', error ? 'is-invalid' : '']" v-model="formattedValue"
        placeholder="R$ 0,00" ref="inputRef" :id="inputId">
    <div :class="error ? 'invalid-feedback' : ''">
        {{ error }}
    </div>
</template>

<script setup lang="ts">

import { watch } from "vue";

import { useCurrencyInput } from "vue-currency-input";

const props = defineProps({ modelValue: Number, error: String, inputId: String });

// trata alerts do v-bind do comp pai.
const emit = defineEmits<{
    (e: "update:modelValue", val: number | undefined): void
    (e: "change", val: number): void
    (e: "input", val: number): void
    (e: "blur"): void
}>();

const { inputRef, formattedValue, setValue } = useCurrencyInput({
    currency: "BRL",
    hideCurrencySymbolOnFocus: false,
    hideGroupingSeparatorOnFocus: false,
    precision: 2,
    valueRange: { min: 1, max: 200 },
});

watch(() => props.modelValue, (value) => {
    setValue(value);
    emit("update:modelValue", value);
});

</script>