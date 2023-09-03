import callAxios from "../utils/http";

class Contact {

    static async sendEmail(values) {

        const { data } = await callAxios.post('/contact/store', values)

        console.log(data)
    }

}

export { Contact }