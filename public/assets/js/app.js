// Show map

const divMap = document.querySelector('#map')

if (divMap) {

    var map = L.map('map', {

        dragging: false,
        zoomControl: false,
        minZoom: 13,

    }).setView([-22.8, -47.3], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 13,
        riseOnHover: true,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([-22.8, -47.3]).addTo(map)
}

// Show Password

// const changeVisiblePassword = document.querySelector('#disabledPassword')
// const inputPassword = document.querySelector('#exampleInputPassword1')

// changeVisiblePassword.addEventListener('click', () => {

//     if(inputPassword.type === 'password') {
//         inputPassword.type = 'text'
//         changeVisiblePassword.className = 'fa-solid fa-eye'
//     } else {
//         inputPassword.type = 'password'
//         changeVisiblePassword.className = 'fa-solid fa-eye-slash'
//     }

//     // Quando colocamos um return no JS, ele mata o processo? Pergntar depois ao Alexandre...
// })


// Validation contact

// const http = axios.create({

//     headers: {
//         'Content-type': 'aplication/json',
//         'X-Requested-With': 'XMLHttpRequest'
//     },

//     baseURL: 'http://localhost:9000'
// })

// const form = document.querySelector('form')

// form.addEventListener('submit', async (event) => {

//     event.preventDefault()

//     try {

//         const formData = new FormData(form)

//         const { data } = await http.post('/contact/store', formData)
//         const inputBox = document.querySelectorAll('.input-box');
//         const existErrorinput = document.querySelector('.input-error')

//         if (data !== 'success') {

//             let i = 0;

//             for (const key in data) {

//                 const small = document.createElement('small');

//                 if (data.hasOwnProperty.call(data, key)) {

//                     if (typeof data[key] === 'string') {

//                         const formattedField = `#${key.toLocaleLowerCase()}`;
//                         const input = document.querySelector(formattedField);

//                         if (input.value === '') {
//                             input.classList.add('input-error')
//                             input.appendChild(small).textContent = data[key]
//                             // console.log(inputBox[i].append(small).textContent = data[key]);
//                         } else {
//                             input.classList.remove('input-error')
//                         }

//                         i++;
//                     }

//                 }

//             }

//         }

//     } catch (error) {
//         console.log(error)
//     }

// })

// const modalDelete = document.querySelector('#modal-delete')
// const myInput = document.querySelector('#btn-delete')

// modalDelete.addEventListener('shown.bs.modal', event => {

//   event.preventDefault()

//   myInput.focus()

// })