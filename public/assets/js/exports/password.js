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
            // Quando colocamos um return no JS, ele mata o processo? Pergntar depois ao Alexandre...
        })
    }
}

