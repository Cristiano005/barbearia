import callAxios from "./exports/http"
import showOrHide from "./exports/password"
import viewMap from "./exports/map"
import edit from "./exports/admin/edit"
import validateFields from "./exports/validateFields"
import destroy from "./exports/admin/delete"

window.onload = () => {

    const changeVisiblePassword = document.querySelector('#disabledPassword')
    const inputPassword = document.querySelector('#exampleInputPassword1')
    const formRegisterNewAdmin = document.querySelector('#formRegisterNewAdmin')
    const formLogin = document.querySelector('#formLogin')
    const formContact = document.querySelector('#formContact')
    const formSolicitationPassword = document.querySelector('#formSolicitationRedefinePassword')
    const formRedefinePassword = document.querySelector('#formRedefinePassword')
    const formUpdateRegister = document.querySelector('#formUpdateRegister')
    const divMap = document.querySelector('#map')

    const token = window.location.pathname.split('/')

    showOrHide(changeVisiblePassword, inputPassword)
    viewMap(divMap)

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

    validateFields(formUpdateRegister, callAxios, `/admin/home/update/${window.location.pathname.split('/')[3]}`, {
        isByMessage: {
            status: true,
            color: 'success',
            message: 'Data updated with success',
            elementToMessage: 'span#message',
            resetForm: false,
        },
    })

    edit(callAxios)
    destroy(callAxios)
}