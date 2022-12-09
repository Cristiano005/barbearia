export default function validateFields(form, callAxios, endpoint, response = {
    isByMessage : {
        status: false,
        color: '',
        message: '',
    },
    redirect: ''
}) {

    if (form) {

        form.addEventListener('submit', async event => {

            event.preventDefault()

            try {

                const formData = new FormData(form)
                const { data } = await callAxios.post(endpoint, formData)

                if (data !== 'success') {

                    for (const key in data) {

                        if (data.hasOwnProperty.call(data, key)) {

                            if (typeof data[key] === 'string') {

                                const formattedField = `form .${key.toLocaleLowerCase()}`;
                                const input = document.querySelector(formattedField);
                                const label = document.querySelector(`#label-${key.toLocaleLowerCase()}`)
                
                                if (input.value === '') {
                                    input.classList.add('border-danger')
                                    input.classList.remove('border-dark')
                                    label.textContent = data[key]
                                } else {
                                    input.classList.add('border-dark')
                                    input.classList.remove('border-danger')
                                    label.textContent = data[key].charAt(0).toLocaleUpperCase() + data[key].slice(1)
                                    label.classList.add('text-danger')
                                    // Deixa a primeira letra em maiúsculo
                                }

                            }

                        }
                    }
                }

                else {

                    if(response.isByMessage.status) {

                        const flashMessage = document.querySelector('h3#title-section')
                        const oldValue = flashMessage.textContent

                        flashMessage.textContent = response.isByMessage.message
                        flashMessage.classList.add(`text-${response.isByMessage.color}`)

                        form.reset() // limpa o formulário
                      
                        setTimeout(() => {
                            flashMessage.textContent = oldValue
                            flashMessage.classList.remove(`text-${response.isByMessage.color}`)
                        }, 5000);

                    } else {
                        window.location.href = response.redirect                    
                    }

                }

            } catch (error) {
                console.log(error)
            }

        })
    }

}