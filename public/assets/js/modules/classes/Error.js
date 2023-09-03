import { Validation } from "./Validation";

class Error {

    static renderError(fields) {

        fields.forEach(field => {

            let labelElement = document.querySelector(`#label-${field}`);
            
            if (Validation.errors[field]) {
                labelElement.classList.add('text-danger')
                labelElement.textContent = `${Validation.errors[field]}`;
            } 

            else {
                labelElement.classList.remove('text-danger')
                labelElement.textContent = `${field.charAt(0).toUpperCase() + field.slice(1).replace('_', ' ')}`; 
            }
           
        });

    }

}

export {Error}