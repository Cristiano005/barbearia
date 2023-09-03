import callAxios from "../utils/http";
import { Error } from "../classes/Error";
import { Validation } from "../classes/Validation";

class Authentication {

    static async auth(form) {

         if(form) {

                form.addEventListener('submit', async (event) => {

                event.preventDefault()
            
                const fields = ['email', 'password']
            
                Validation.validate(fields)

                Error.renderError(fields)
            
                if (Object.keys(Validation.errors).length > 0) {
                    return
                }

                try {

                    const { data } = await callAxios.post('/auth/store', Validation.validatedValues)

                    if(data === 'success') {
                        window.location.href = '/admin'  
                        return
                    } 

                    for (const key in data) {
                        if (Object.hasOwnProperty.call(data, key)) {
                            Validation.errors[key] = data[key]
                        }
                    }

                    Error.renderError(Object.getOwnPropertyNames(data))
                }
                
                catch (error) {
                    console.log(error)
                }
       
            })  
            
        }
    }    
}

export { Authentication }