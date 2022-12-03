import debounce from 'underscore/modules/debounce'

export default function search(callAxios, search, autocomplete) {

    if(search) {
        search.addEventListener('input', debounce(async (event) => {

            const { data } = await callAxios.get(`/admin/home/show/${event.target.value}`, {
                params: {
                    id: event.target.value
                }
            })

            console.log(data)
        }, 500))
    }

}