class Password {

    static toggleShow(input) {

        if(input.type === 'password') {
            input.type = 'text'
            return
        } 

        input.type = 'password'
    }

}

export { Password }

// export default function showOrHide() {

//     const changeVisiblePassword = document.querySelector('#disabledPassword')
//     const inputPassword = document.querySelector('#exampleInputPassword1')

//     if (changeVisiblePassword) {

//         changeVisiblePassword.addEventListener('click', () => {

//             if (inputPassword.type === 'password') {
//                 inputPassword.type = 'text'
//                 changeVisiblePassword.className = 'fa-solid fa-eye'
//             } else {
//                 inputPassword.type = 'password'
//                 changeVisiblePassword.className = 'fa-solid fa-eye-slash'
//             }
        
//         })
//     }
// }