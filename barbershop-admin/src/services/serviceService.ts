import { axiosInstance } from "@/helpers/helper";
import type { FetchServicesParams } from "@/helpers/types";

async function fetchServices({currentPage = 1, all = false }: FetchServicesParams) {
    const queryString = all ? "?all=true" : `?page=${currentPage}`;
    const { data } = await axiosInstance.get(`/api/v1/admin/services${queryString}`);
    return data.data;
}

async function addService(dataBody: { name: string, price: string }) {
    const { data } = await axiosInstance.post(`/api/v1/admin/services`, dataBody);
    return data;
}

async function updateService(id: number, dataBody: {name: string, price: string}) {
    const { data } = await axiosInstance.put(`/api/v1/admin/services/${id}`, dataBody);
    return data;
}

async function deleteService(id: number) {
    const { data } = await axiosInstance.delete(`/api/v1/service/${id}`);
    return data;
}

export {
    fetchServices, addService, updateService, deleteService
}