import callAxios from "./exports/http"
import showOrHide from "./exports/password"
import viewMap from "./exports/map"
import search from "./exports/admin/search"
import edit from "./exports/admin/edit"
import validateFields from "./exports/validateFields"
import destroy from "./exports/admin/delete"

const changeVisiblePassword = document.querySelector('#disabledPassword')
const inputPassword = document.querySelector('#exampleInputPassword1')
const formRegisterNewAdmin = document.querySelector('#formRegisterNewAdmin')
const formLogin = document.querySelector('#formLogin')
const divMap = document.querySelector('#map')
const searchInput = document.querySelector('#searchData')
const autocomplete = document.querySelector('#autocomplete')

showOrHide(changeVisiblePassword, inputPassword)
viewMap(divMap)

validateFields(formLogin, callAxios, '/login/store', {
    isByMessage: {
        status: false
    },
    'redirect' : '/admin'
})

validateFields(formRegisterNewAdmin, callAxios, '/admin/home/store', {
    isByMessage: {
        status: true,
        color: 'success',
        message: 'Account registered with success',
    },
    'redirect' : '/admin/home'
})

search(callAxios, searchInput, autocomplete)
edit(callAxios)
destroy(callAxios)