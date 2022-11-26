import axios from "axios"

const callAxios = axios.create({
    headers: {
        'Content-type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    baseURL: 'http://localhost:9000'
});

export default callAxios

