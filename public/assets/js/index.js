import callAxios from "./exports/http"
import showOrHide from "./exports/password"
import viewMap from "./exports/map"
import edit from "./exports/admin/edit"
import validateFields from "./exports/validateFields"
import destroy from "./exports/admin/delete"
import dataList from "./exports/admin/dataList"

window.onload = () => {

    const formRegisterNewAdmin = document.querySelector('#formRegisterNewAdmin')
    const formLogin = document.querySelector('#formLogin')
    const formContact = document.querySelector('#formContact')
    const formSolicitationPassword = document.querySelector('#formSolicitationRedefinePassword')
    const formRedefinePassword = document.querySelector('#formRedefinePassword')
    const formUpdateRegister = document.querySelector('#formUpdateRegister')

    const token = window.location.pathname.split('/')

    validateFields(formLogin, callAxios, '/login/store', {
        isByMessage: {
            status: false
        },
        'redirect': '/admin'
    })

    validateFields(formRegisterNewAdmin, callAxios, '/admin/register/store', {
        isByMessage: {
            status: true,
            color: 'success',
            message: 'Account registered with success',
        },
    })

    validateFields(formContact, callAxios, '/contact/store', {
        isByMessage: {
            status: true,
            color: 'success',
            message: 'E-mail sell with success',
        },
    })

    validateFields(formSolicitationPassword, callAxios, `/password/store`, {
        isByMessage: {
            status: true,
            color: 'success',
            message: 'Your order has been accepted, check your email.',
            elementToMessage: 'span#message'
        },
    })

    validateFields(formRedefinePassword, callAxios, `/password/update/${token[3]}`, {
        isByMessage: {
            status: false,
        },
        redirect: '/login'
    })

    edit(callAxios)
    destroy(callAxios) 
    showOrHide()
    viewMap()
}

dataList(callAxios)