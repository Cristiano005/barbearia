import axios from "axios";

const axiosInstance: AxiosInstance = axios.create({
    baseURL: "http://localhost:9000",
    withCredentials: true,
});

function formatCurrency(value: number | null | undefined): string {

    const locale: string = "en-US";
    const currencyCode: string = "USD";

    if (value === null || value === undefined || isNaN(value)) {
        return new Intl.NumberFormat(locale, {
            style: "currency",
            currency: currencyCode,
            minimumFractionDigits: 2,
        }).format(0);
    }

    const numericValue = value;

    return new Intl.NumberFormat(locale, {
        style: "currency",
        currency: currencyCode,
        minimumFractionDigits: 2,
    }).format(numericValue);
}

export {
    axiosInstance, formatCurrency
}