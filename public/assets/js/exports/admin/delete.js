export default function destroy(callAxios) {

    const btnsDelete = document.querySelectorAll('#btn-delete')
    const confirmDelete = document.querySelector('#confirm-delete')
    const btnCancel = document.querySelector('#btn-cancel')

    // const modal = document.querySelector('#modal-delete')

    const url = window.location.pathname.split('/')

    console.log(btnsDelete)

    if (btnsDelete) {

        for (const btnDelete of btnsDelete) {

            btnDelete.addEventListener('click', async (event) => {

                const id = event.target.value

                alert('oii')

                console.log(id)

                confirmDelete.addEventListener('click', async (event) => {

                    event.preventDefault()

                    try {

                        const { data } = await callAxios.post(`/admin/home/destroy/${url[3]}`,id)

                        console.log(data)

                        if(data !== 'success') {

                            
                        } else {

                            btnCancel.click() // simula um evento de clique
                            // window.location.href = '/admin/home'

                            // setTimeout(() => {
                            //     flashMessage.textContent = oldValue
                            //     flashMessage.classList.remove(`text-${response.isByMessage.color}`)
                            // }, 5000);
                        }

                    } 
                    
                    catch (error) {
                        console.log(error)
                    }

                })



            })

        }

    }
}