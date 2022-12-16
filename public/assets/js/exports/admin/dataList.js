export default async function dataList(callAxios) {

    try {

        const thead = document.querySelector('thead')
        const tbody = document.querySelector('tbody')

        const page = new URLSearchParams(window.location.search).get('page')
        const url = window.location.pathname.split('/')

        const { data } = await callAxios.get(`/admin/home/show/${url[3]}`, {
            params: {
                page: page,
            },
        })

        let property = Object.keys(data[0]).map(function(key) { 
            return key; // Transforma um objeto em array para pegar as propriedade
        });

        let render = ''
        
        property.forEach((element, index) => {

            render += `
                <th> ${element} </th>
            `

            if(property.length === index + 1) {
                 render += `<th colspan="2"> Actions </th>`
            }

            thead.innerHTML = render
        })

        if(data.length > 0) {

            let render = ''

            for (let i = 0; i < data.length; i++) {
                
                let valuesInArray = Object.values(data[i]).map(function(value) {
                    return value;
                })
        
                valuesInArray.forEach((element, index) => {
    
                    let id = valuesInArray[0]
    
                    render += `  
                        
                        <td> ${element} </td>
                              
                    `
    
                    if(valuesInArray.length === index + 1) {
    
                        render += `
                        
                            <td>
                                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" 
                                id="btn-edit" data-bs-target="#modal-edit" value=${+id}> 
                                    Edit 
                                </button>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-danger" id="btn-delete" data-bs-toggle="modal" 
                                data-bs-target="#modal-delete" value=${+id}> 
                                    Delete 
                                </button>
                            </td>
                        
                            </tr>
                        `
                    }
    
                    tbody.innerHTML = render
                })
            } 

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