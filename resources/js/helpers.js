const formatPrice = (number) => {
    return parseFloat(number).toFixed(2);
}
const formatDate = (date) => {
    return new Date(date).toLocaleString('en-US', {
        month: 'numeric',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    });
}
export { formatPrice, formatDate };
