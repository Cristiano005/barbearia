export default async function dataList(callAxios) {

    try {

        const tbody = document.querySelector('tbody')

        const page = new URLSearchParams(window.location.search).get('page')
        const url = window.location.pathname.split('/')

        const { data } = await callAxios.get(`/admin/home/show/${url[3]}`, {
            params: {
                page: page,
            },
        })

        console.log(data)

        let render = ''

        if(data.length > 0) {

            data.forEach((element) => {

                render += [`
                    
                    <tr> 
                        <td>  ${element.id} </td>
                        <td>  ${element.name} </td>
                        <td>  ${element.payment} </td>
                        <td>  ${element.date} </td>
                        <td>  ${element.schedule} </td>
                        <td>
                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" 
                            id="btn-edit" data-bs-target="#modal-edit" value=${element.id}> 
                                Edit 
                            </button>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-danger" id="btn-delete" data-bs-toggle="modal" 
                            data-bs-target="#modal-delete" value=${element.id}> 
                                Delete 
                            </button>
                        </td>
                    </tr>
                        
                `]
    
                tbody.innerHTML = render
            })

        }

        else {

            const table = document.querySelector('#table')
            table.classList.add('d-none')

            const section = document.querySelector('#tableClients')
            const createdH2 = document.createElement('h2')
            let h2 = section.appendChild(createdH2)
            h2.textContent = 'No data'
            h2.classList.add('text-center')
        }
      
        
    } catch (error) {
        console.log(error)
    }

}