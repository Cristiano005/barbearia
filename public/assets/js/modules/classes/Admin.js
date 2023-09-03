import callAxios from "../utils/http";
import { Error } from "./Error";
import { Validation } from "./Validation";

class Admin {

    static register(form, responseTag) {

        if(form) {

            form.addEventListener('submit', async (event) => {

                const fields = ['name', 'email', 'password']

                event.preventDefault()

                Validation.validate(fields)

                Error.renderError(fields)

                if (Object.keys(Validation.errors).length > 0) {
                    return
                }

                try {

                    const { data } = await callAxios.post('/admin/register/store', Validation.validatedValues)

                    if(data !== "success") {

                        for (const key in data) {
                            if (Object.hasOwnProperty.call(data, key)) {
                                Validation.errors[key] = data[key]
                            }
                        }

                        Error.renderError(Object.getOwnPropertyNames(data))
                        return
                    }

                    responseTag.textContent = `Admin registered successfully`
                    responseTag.classList.add('text-success')

                    setTimeout(() => {
                        responseTag.textContent = `Register new admin`
                        responseTag.classList.remove('text-success')
                    }, 2000)

                    form.reset()
                } 
                
                catch (error) {
                    console.log(error)
                }
            })

        }

    }

    static edit(elements, inputs) {
        
        elements.forEach(element => {

            element.addEventListener('click', async () => {

                try {

                    const table = new URLSearchParams(window.location.search)
    
                    const idOfRegister = element.getAttribute('data-id')
                    
                    const { data } = await callAxios.get('/admin/home/edit', {params: {id: idOfRegister, table: table.get('table')} })

                    console.log(data)

                    const register = data[0]
    
                    inputs.forEach(input => {
                        input.value = register[input.id]
                    })
                } 
                
                catch (error) {
                    console.log(error)   
                }
    
            })

        })

    }

    static delete(buttonsOfDelete, buttonOfConfirmationDelete) {

        if(buttonsOfDelete) {

            buttonsOfDelete.forEach(button => {

                const id = button.getAttribute('data-id')
                const table = new URLSearchParams(window.location.search)

                button.addEventListener('click', () => {

                    buttonOfConfirmationDelete.addEventListener('click', async (event) => {

                        event.preventDefault()

                        try {
                        
                            const { data } = await callAxios.delete('/admin/home/destroy', {params: {id: id, table: table.get('table')} })

                            if(data) {
                                location.reload()
                            }

                        } 
                        
                        catch (error) {
                            console.log(error)    
                        }

                    })

                })

            })

        }


    }

}

export { Admin }