import axios from "axios";
import type AxiosInstance from "axios";

const axiosInstance: AxiosInstance = axios.create({
    baseURL: 'http://localhost:9000',
    withCredentials: true,
});

export {
    axiosInstance
}