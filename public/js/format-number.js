function formatNumber(number, decimal = 2, unite = null, separateur = " ") {
    
    let  value = (number).toLocaleString("en-US",{
            minimumFractionDigits: decimal
    }).replaceAll(",", separateur);

    if (unite !== null) return value + " " + unite
    return value
}
