import callAxios from "./exports/http"
import showOrHide from "./exports/password"
import viewMap from "./exports/map"
import validateLogin from "./exports/validationLogin"
import search from "./exports/search"

const changeVisiblePassword = document.querySelector('#disabledPassword')
const inputPassword = document.querySelector('#exampleInputPassword1')
const formLogin = document.querySelector('#login form')
const divMap = document.querySelector('#map')
const searchInput = document.querySelector('#searchData')
const btnsEdit = document.querySelectorAll('#btn-edit')
const name = document.querySelector('form #name')

showOrHide(changeVisiblePassword, inputPassword)
viewMap(divMap)
validateLogin(formLogin, callAxios)
search(searchInput)

for (const btnEdit of btnsEdit) {

    btnEdit.addEventListener('click', async (event) => {

        try {

            const { data } = await callAxios.get('admin/home/show', {
                params: {
                    id: event.target.value
                }
            })

            console.log(data)
        } 
        
        catch (error) {
            console.log(error)
        }

    })

}