import axios from "axios";

const axiosInstance = axios.create({
    baseURL: 'http://localhost:9000',
    withCredentials: true,
});

async function getAllServices() {

    try {
        const { data } = await axiosInstance.get("/api/v1/services");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function getAvailableDateTimes() {
    try {
        const { data } = await axiosInstance.get(`/api/v1/availabilities`);
        return data.data;
    }

    catch (error) {
        console.log(error);
    }
}

export {
    axiosInstance, getAllServices, getAvailableDateTimes
}