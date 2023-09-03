import { elements } from "../html_selections/elements"
import callAxios from "../utils/http"
import { Error } from "./Error"
import { Validation } from "./Validation"

class Schedules {

    static async renderSchedulesInSelect(dateSelect, scheduleSelect) {

        try {

            if(!dateSelect) {
                return
            }

            const selectedDate = dateSelect.options[dateSelect.selectedIndex]

            const schedules = await Schedules.getSchedules(selectedDate.textContent)

            if(!schedules.length) {
                scheduleSelect.innerHTML = `<option value="no schedule unavailable"> no schedule unavailable </option>`
                return
            }

            schedules.forEach((prop) => scheduleSelect.innerHTML = `<option value=${prop.schedule}> ${prop.schedule} </option>`)
        } 
        
        catch (error) {
            console.log(error)    
        }

    }

    static async getSchedules(selectedDate) {

        const formattedDate = encodeURIComponent(selectedDate)

        const { data } = await callAxios.get(`schedule?date=${formattedDate}`)

        return data
    }
 
    static saveAppointmentScheduled(form) {
    
        if(form) {
        
            form.addEventListener('submit', async event => {

                event.preventDefault()

                const fields = ['name', 'service', 'date', 'available_schedules']

                Validation.validate(fields)

                Error.renderError(fields)

                if (Object.keys(Validation.errors).length > 0) {
                    return
                }

                try {
                    const { data } = await callAxios.post('/schedule/store', Validation.validatedValues)

                    if(data !== "success") {

                        for (const key in data) {

                            if (Object.hasOwnProperty.call(data, key)) {
                                Validation.errors[key] = data[key]
                            }
                        }

                        Error.renderError(Object.getOwnPropertyNames(data))
                        return
                    }

                    this.renderSchedulesInSelect(elements.dateSelect, elements.scheduleSelect)

                    const responseTag = document.querySelector('#schedule-title')

                    responseTag.textContent = "Your appointment has been scheduled successfully." 
                    responseTag.classList.add('text-success')

                    setTimeout(() => {
                        responseTag.textContent = "Schedule your hourly"
                        responseTag.classList.remove('text-success')
                    }, 5000)


                    form.reset()
                } 
                
                catch (error) {
                    console.log(error)
                }
            })

        }

    }
}


export { Schedules }