export default function edit(callAxios) {

    const btnsEdit = document.querySelectorAll('#btn-edit')
    const name = document.querySelector('form #name')
    const payment = document.querySelector('form #payment')
    const date = document.querySelector('form #date')
    const schedule = document.querySelector('form #schedule')
  
    if (btnsEdit) {

        const url = window.location.pathname.split('/')
        const formsInputs = [name, payment, date, schedule]
        const inputsEdit = ['name', 'payment', 'date', 'schedule']

        for (const btnEdit of btnsEdit) {

            btnEdit.addEventListener('click', async (event) => {

                try {

                    const { data } = await callAxios.get(`admin/home/edit/${url[3]}`, {
                        params: {
                            id: event.target.value
                        }
                    })

                    for (let index = 0; index < formsInputs.length; index++) {

                        let att = inputsEdit[index]

                        if (data[0][att]) {
                            formsInputs[index].value = data[0][att]
                        } else {
                            formsInputs[index].setAttribute('disabled', 'Impossible for update')
                        }
                    }
                }

                catch (error) {
                    console.log(error)
                }

            })

        }

    }

}
