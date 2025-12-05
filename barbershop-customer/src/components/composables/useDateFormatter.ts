export function useDateFormatter() {

    const getFormattedDate = (date: Date) => {
        const newDate = new Date(date);
        const day = String(newDate.getDate()).padStart(2, '0');
        const month = String(newDate.getMonth() + 1).padStart(2, '0');
        const year = newDate.getFullYear();

        return `${year}-${month}-${day}`;
    };

    const formatToHuman = (date: Date) => {
        return new Intl.DateTimeFormat("pt-BR").format(date);
    };

    const toLocalDate = (dateString: string) => {
        const [year, month, day] = dateString.split("-").map(Number);
        return new Date(year, month - 1, day);
    };

    return {
        getFormattedDate,
        formatToHuman,
        toLocalDate
    };
}
