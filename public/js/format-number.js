function formatNumber(number, decimal = 2, unite = null, separateur = " ") {
    let  value = (number).toLocaleString(undefined,{
            minimumFractionDigits: decimal
        }
    ).replace(",", separateur);

    if (unite !== null) return value + " " + unite
    return value
}
