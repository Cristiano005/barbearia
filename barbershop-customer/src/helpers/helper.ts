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

    // stopped here, i need create a new field in avaibaliweies, field like "ava_exc", you know?

    try {
        const { data } = await axiosInstance.get("/api/v1/services");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

export {
    axiosInstance, validate, getAllServices
}