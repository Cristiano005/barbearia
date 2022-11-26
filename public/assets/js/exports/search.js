export default function search(search) {

    if(search) {
        search.addEventListener('input', event => {
            console.log(event.target.value)
        })
    }

}