const elements = {
    divMap: document.querySelector('#map'),
    scheduleSelect: document.querySelector('#available_schedules'),
    dateSelect: document.querySelector('#date'),
    inputPasswordFromLogin: document.querySelector('#password'),
    togglePasswordElement: document.querySelector('#disabledPassword'),
    scheduleForm: document.querySelector('#scheduleForm'),
    loginForm: document.querySelector('#formLogin'),
    contactForm: document.querySelector('#contactForm'),
    admin: {
        registerForm: document.querySelector('#registerForm'),
        titleFormRegister: document.querySelector('.title-form'),
        editButtons: document.querySelectorAll('.editButton'),
        inputsOfEdit: document.querySelectorAll('#editForm input'),
        deleteButtons: document.querySelectorAll('.deleteButton'),
        confirmDelete: document.querySelector('#confirm-delete'),
    }
}

export { elements }