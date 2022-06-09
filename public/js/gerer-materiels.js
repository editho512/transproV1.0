let pieces = new Object()
let editing = false
let addMateriel = document.getElementById('addMateriel')

let nom = document.getElementById('nom')
let frs = document.getElementById('frs')
let contactFrs = document.getElementById('contact-frs')
let pu = document.getElementById('pu')
let quantite = document.getElementById('quantite')
let total = document.getElementById('total')

let result = document.getElementById('result')

addMateriel.addEventListener('click', e => {
    e.preventDefault()

    if (nom.value === "") { $('#error p').html("Veillez remplir le nom de la matériel"); $('#error').modal('show'); return; }
    /*if (frs.value === "") { $('#error p').html("Veillez remplir le nom de "); $('#error').modal('show'); return; }
    if (nom.value === "") { $('#error p').html("Veillez remplir le nom de la matériel"); $('#error').modal('show'); return; }*/
    if (isNaN(parseFloat(pu.value)) || parseFloat(pu.value) < 0) { $('#error p').html("Prix unitaire vide ou invalide"); $('#error').modal('show'); return; }
    if (isNaN(parseInt(quantite.value)) || parseInt(quantite.value) < 0) { $('#error p').html("Quantité vide ou invalide"); $('#error').modal('show'); return; }
    if (isNaN(parseFloat(total.value)) || parseFloat(total.value) < 0) { $('#error p').html("Montant total vide ou invalide"); $('#error').modal('show'); return; }

    let tr = document.createElement('tr')
    let tuple = `<td>${nom.value}</td>
                <td>${frs.value}</td>
                <td>${contactFrs.value}</td>
                <td>${formatNumber(parseFloat(pu.value), 2, "Ar")}</td>
                <td>${formatNumber(parseInt(quantite.value), 0)}</td>
                <td>${formatNumber(parseFloat(total.value), 2, "Ar")}</td>
                <td class='d-inline-flex'>
                    <button onclick='editPiece(this)' class='btn btn-primary mr-2'><i class='fa fa-edit'></i></button>
                    <button onclick='removePiece(this)' class='btn btn-danger'><i class='fa fa-minus'></i></button>
                </td>`

    if (pieces[nom.value]) { alert('Cette piece existe déja dans la liste'); resetFields(); return; }

    tr.innerHTML = tuple
    result.appendChild(tr)

    let key = nom.value

    pieces[key] = {
        nom: nom.value,
        pu: pu.value,
        quantite: quantite.value,
        total: total.value,
        frs: frs.value,
        contactFrs: contactFrs.value,
    }

    resetFields()
})

function resetFields () {
    nom.value = null; pu.value = null; quantite.value = null; total.value = null; frs.value = null; contactFrs.value = null;
}


function removePiece (button) {
    window.event.preventDefault()
    let tr = button.parentElement.parentElement

    if (editing === tr.firstElementChild.innerHTML) { alert('Vous avez unee modification en cours'); return; }

    delete pieces[tr.firstElementChild.innerHTML]
    tr.remove()
}

nom.addEventListener('blur', e => {
    e.preventDefault()
    calculerMontant()
})

pu.addEventListener('blur', e => {
    e.preventDefault()
    calculerMontant()
})

quantite.addEventListener('blur', e => {
    e.preventDefault()
    calculerMontant()
})

function calculerMontant () {
    if (nom.value !== "" && !isNaN(parseFloat(pu.value)) && !isNaN(parseInt(quantite.value))){
        total.value = parseFloat(pu.value) * parseInt(quantite.value).toString()
    }
}
