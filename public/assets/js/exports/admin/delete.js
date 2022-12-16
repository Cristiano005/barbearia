import dataList from "./dataList"

export default async function destroy(callAxios) {

    const btnsDelete = document.querySelectorAll('#btn-delete')
    const confirmDelete = document.querySelector('#confirm-delete')
    const btnCancel = document.querySelector('#btn-cancel')

    const url = window.location.pathname.split('/')

    console.log(btnsDelete)

    if (btnsDelete) {

        let id = ''

        for (const btnDelete of btnsDelete) {

            btnDelete.addEventListener('click', (event) => {

                console.log(btnDelete)

                id = +event.target.value

                console.log(id)

                confirmDelete.addEventListener('click', async (event) => {

                    console.log(btnDelete)

                    event.preventDefault()

                    try {

                        const { data } = await callAxios.post(`/admin/home/destroy/${url[3]}`,id)

                        console.log(data)

                        if(data !== 'success') {
                            alert('Register does not exist.')                            
                        } else {
                            btnCancel.click() // simula um evento de clique
                            dataList(callAxios)
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