export default function destroy(callAxios) {

    const btnsDelete = document.querySelectorAll('#btn-delete')
    const confirmDelete = document.querySelector('#confirm-delete')

    // const modal = document.querySelector('#modal-delete')

    const url = window.location.pathname.split('/')

    if (btnsDelete) {

        for (const btnDelete of btnsDelete) {

            btnDelete.addEventListener('click', async (event) => {

                const id = event.target.value

                confirmDelete.addEventListener('click', async (event) => {

                    event.preventDefault()

                    try {

                        const { data } = await callAxios.post(`/admin/home/destroy/${url[3]}/${id}`)

                        console.log(data)

                        if(data !== 'success') {

                            
                        } else {
                            window.location.href = '/admin/home/destroy'
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