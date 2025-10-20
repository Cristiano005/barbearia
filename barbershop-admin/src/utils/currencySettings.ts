import type { CurrencyInputOptions } from "vue-currency-input";

export const BRL_INPUT_OPTIONS: CurrencyInputOptions = {
    locale: "pt-BR",
    currency: "BRL",
    hideCurrencySymbolOnFocus: false,
    hideGroupingSeparatorOnFocus: false,
    precision: 2,
    valueRange: { min: 1 },
};