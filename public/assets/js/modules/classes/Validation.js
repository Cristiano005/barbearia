class Validation {

    static errors = {}

    static validatedValues = {}

    static #rules = {
        
        email: function(value) {
        
            const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

            if(!pattern.test(value)) {
                return 'Invalid e-mail'
            }

            return true
        },

        password: function(value) {
            
            const pattern = /.{8,}/

            if(!pattern.test(value)) {
                return 'Password required is min 8 characters'
            }

            return true
        },

        service: function(value) {

            const pattern = /(hair|beard)/

            if(!pattern.test(value)) {
                return 'Unavailable service'
            }

            return true
        },

        date: function (value) {

            const pattern = /(0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/[0-9]{4}/

            if(!pattern.test(value)) {
                return 'Unavailable date'
            }

            return true
        },

        available_schedules: function (value) {

            const pattern = /(1?[0-9]):[0-5][0-9]/

            if(!pattern.test(value)) {
                return 'Unavailable schedule'
            }

            return true
        }
    }

    static validate(fields) {

        fields.forEach(element => {

            const value = document.querySelector(`#${element}`).value

            if(!value) {
                this.errors[element] = `Empty ${element}`
                return
            } 

            else {
                delete this.errors[element]
                this.validatedValues[element] = value
            }

            if(!Object.hasOwn(this.#rules, element)) {
                return
            }

            const result = this.#rules[element](value)

            if(result !== true) {
                this.errors[element] = result
                return
            }

            delete this.errors[element]

            this.validatedValues[element] = value
        })
    
    }

}

export { Validation }