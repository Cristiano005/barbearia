import { Password } from "./modules/classes/Password"
import { Schedules } from "./modules/classes/Schedule"
import { Map } from "./modules/libraries/Map"
import { elements } from "./modules/html_selections/elements"
import { Authentication } from "./modules/auth/Authentication"
import { Validation } from "./modules/classes/Validation"
import { Contact } from "./modules/classes/Contact"
import { Admin } from "./modules/classes/Admin"
import { Error } from "./modules/classes/Error"

document.addEventListener('DOMContentLoaded', () => {
    
    if(elements.contactForm) {
        
        elements.contactForm.addEventListener('submit', (event) => {

            event.preventDefault()

            const fields = ['name', 'email', 'subject', 'message']

            Validation.validate(fields)

            Error.renderError(fields)

            if (Object.keys(Validation.errors).length > 0) {
                return
            }

            Contact.sendEmail(Validation.validatedValues)
        })
    }

    Schedules.saveAppointmentScheduled(elements.scheduleForm)

    Authentication.auth(elements.loginForm)

    Map.createMap(elements.divMap)

    elements.togglePasswordElement ? elements.togglePasswordElement.addEventListener('click', () => Password.toggleShow(elements.inputPasswordFromLogin)) : ''

    Schedules.renderSchedulesInSelect(elements.dateSelect, elements.scheduleSelect)

    elements.dateSelect ? elements.dateSelect.addEventListener('change', () => Schedules.renderSchedulesInSelect(elements.dateSelect, elements.scheduleSelect))
    : ''

    Admin.register(elements.admin.registerForm, elements.admin.titleFormRegister)

    Admin.edit(elements.admin.editButtons, elements.admin.inputsOfEdit)

    Admin.delete(elements.admin.deleteButtons, elements.admin.confirmDelete)
})