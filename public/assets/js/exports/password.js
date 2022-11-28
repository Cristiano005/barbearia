export default function showOrHide(changeVisiblePassword, inputPassword) {
    if (changeVisiblePassword) {

        changeVisiblePassword.addEventListener('click', () => {

            if (inputPassword.type === 'password') {
                inputPassword.type = 'text'
                changeVisiblePassword.className = 'fa-solid fa-eye'
            } else {
                inputPassword.type = 'password'
                changeVisiblePassword.className = 'fa-solid fa-eye-slash'
            }
        
        })
    }
}

