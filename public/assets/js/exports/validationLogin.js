export default function validateLogin(form, callAxios) {

    if (form) {

        form.addEventListener('submit', async event => {

            event.preventDefault()

            try {

                const formData = new FormData(form)
                const { data } = await callAxios.post('/login/store', formData)

                console.log(typeof data)

                if (data !== 'success') {

                    for (const key in data) {

                        console.log(data[key])

                        if (data.hasOwnProperty.call(data, key)) {

                            if (typeof data[key] === 'string') {

                                console.log(key)

                                const formattedField = `form .${key.toLocaleLowerCase()}`;
                                const input = document.querySelector(formattedField);
                                const label = document.querySelector(`#label-${key}`)

                                console.log(formattedField)

                                if (input.value === '') {
                                    console.log(input)
                                    input.classList.add('border-danger')
                                    input.classList.remove('border-dark')
                                    label.textContent = data[key]
                                } else {
                                    console.log(input)
                                    input.classList.add('border-dark')
                                    input.classList.remove('border-danger')
                                    label.textContent = data[key].charAt(0).toLocaleUpperCase() + data[key].slice(1)
                                    // Deixa a primeira letra em maiúsculo
                                }

                            }

                        }
                    }

                }

                else {
                    window.location.href = '/admin/home/clients'
                }

            } catch (error) {
                console.log(error)
            }

        })
    }

}
