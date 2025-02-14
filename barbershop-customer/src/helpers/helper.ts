import axios from "axios";
import type AxiosInstance from "axios";

const axiosInstance: AxiosInstance = axios.create({
    baseURL: 'http://localhost:9000',
    withCredentials: true,
});

interface FieldAndRule {
    name: string;
    rules: string[];
    value: string;
}

function validate(elementInput: HTMLInputElement | null, messageContainer: HTMLDivElement | null, fieldsAndRules: FieldAndRule): boolean {
    let issuesNotFound = true;

    fieldsAndRules.rules.forEach((rule) => {
        if (issuesNotFound) {
            const capitalizeWord = `${fieldsAndRules.name.charAt(0).toUpperCase()}${fieldsAndRules.name.slice(1)}`;

            const nameRegex = /^[a-zA-Zà-ÿÀ-ÿ' -]{2,50}$/;
            const emailRegex = /([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})/;
            const passwordRegex = /^.{8,}$/;

            switch (rule) {
                case 'empty':

                    let isEmpty = false;

                    if (typeof fieldsAndRules.value === "string") {
                        if (fieldsAndRules.value.trim().length === 0) isEmpty = true;
                    } else {
                        if (!fieldsAndRules.value) isEmpty = true;
                    }

                    if (isEmpty) {

                        issuesNotFound = false;

                        if (elementInput && messageContainer) {
                            elementInput.classList.add('is-invalid');
                            messageContainer.classList.add('invalid-feedback');
                            messageContainer.textContent = `Empty ${capitalizeWord}`;
                        }
                    }

                    break;

                case 'name':
                    if (!nameRegex.test(fieldsAndRules.value)) {
                        issuesNotFound = false;

                        if (elementInput && messageContainer) {
                            elementInput.classList.add('is-invalid');
                            messageContainer.classList.add('invalid-feedback');
                            messageContainer.textContent = `Invalid ${capitalizeWord}`;
                        }
                    }

                    break;

                case 'email':
                    if (!emailRegex.test(fieldsAndRules.value)) {
                        issuesNotFound = false;

                        if (elementInput && messageContainer) {
                            elementInput.classList.add('is-invalid');
                            messageContainer.classList.add('invalid-feedback');
                            messageContainer.textContent = `Invalid ${capitalizeWord}`;
                        }
                    }

                    break;

                case 'password':
                    if (!passwordRegex.test(fieldsAndRules.value)) {
                        issuesNotFound = false;

                        if (elementInput && messageContainer) {
                            elementInput.classList.add('is-invalid');
                            messageContainer.classList.add('invalid-feedback');
                            messageContainer.textContent = `${capitalizeWord} must have at least 8 characters`;
                        }
                    }

                    break;
            }
        }
    });

    if (issuesNotFound && elementInput && messageContainer) {
        elementInput.classList.remove('is-invalid');
        messageContainer.classList.remove('invalid-feedback');
        messageContainer.textContent = '';
    }

    return issuesNotFound;
}

async function getAllServices() {

    try {
        const { data } = await axiosInstance.get("/api/v1/services");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function searchTimesAvailable(date: Date | null) {

    selectedDate.value = date

    if (date) {

        try {
            const formattedDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().split("T")[0];
            const { data } = await axiosInstance.get(`/api/v1/availabilities?date=${formattedDate}`);
            timeInput.value?.removeAttribute("disabled");
            return times.value = data.data;
        }

        catch (error) {
            console.log(error);
        }

    }

    else {
        timeInput.value?.setAttribute("disabled", "true");
        selectedTime.value = "";
    }
}

const format = (date: Date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

export {
    axiosInstance, validate, getAllServices, format, searchTimesAvailable
}