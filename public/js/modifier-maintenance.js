
let addMaterielEdit = document.getElementById('addMaterielEdit')

let nomEdit = document.getElementById('nom-edit')
let frsEdit = document.getElementById('frs-edit')
let contactFrsEdit = document.getElementById('frs-contact-edit')
let puEdit = document.getElementById('pu-edit')
let quantiteEdit = document.getElementById('quantite-edit')
let totalEdit = document.getElementById('total-edit')

let resultEdit = document.getElementById('result-edit')

addMaterielEdit.addEventListener('click', e => {
    e.preventDefault()

    if (nomEdit.value === "") { $('#error p').html("Veillez remplir le nom de la matériel"); $('#error').modal('show'); return; }
    if (isNaN(parseFloat(puEdit.value)) || parseFloat(puEdit.value) < 0) { $('#error p').html("Prix unitaire vide ou invalide"); $('#error').modal('show'); return; }
    if (isNaN(parseInt(quantiteEdit.value)) || parseInt(quantiteEdit.value) < 0) { $('#error p').html("Quantite vide ou invalide"); $('#error').modal('show'); return; }
    if (isNaN(parseFloat(totalEdit.value)) || parseFloat(totalEdit.value) < 0) { $('#error p').html("Montant total vide ou invalide"); $('#error').modal('show'); return; }

    let tr = document.createElement('tr')
    let tuple = `<td>${nomEdit.value}</td>
                <td>${frsEdit.value}</td>
                <td>${contactFrsEdit.value}</td>
                <td>${formatNumber(parseFloat(puEdit.value), 2, "Ar")}</td>
                <td>${formatNumber(parseInt(quantiteEdit.value), 0)}</td>
                <td>${formatNumber(parseFloat(totalEdit.value), 2, "Ar")}</td>
                <td class='d-inline-flex'>
                    <button onclick='editPiece(this)' class='btn btn-primary mr-2'><i class='fa fa-edit'></i></button>
                    <button onclick='removePiece(this)' class='btn btn-danger'><i class='fa fa-minus'></i></button>
                </td>`

    if (pieces[nomEdit.value]) { alert('Cette piece existe déja dans la liste'); resetFields(); return; }

    tr.innerHTML = tuple
    resultEdit.appendChild(tr)

    let key = nomEdit.value

    pieces[key] = {
        nom: nomEdit.value,
        frs: frsEdit.value,
        contactFrs: contactFrsEdit.value,
        pu: puEdit.value,
        quantite: quantiteEdit.value,
        total: totalEdit.value
    }

    resetFieldsEdit()
})

function resetFieldsEdit () {
    nomEdit.value = null; puEdit.value = null; quantiteEdit.value = null; totalEdit.value = null; frsEdit.value = null; contactFrsEdit.value = null;
}

nomEdit.addEventListener('blur', e => {
    e.preventDefault()
    calculerMontantEdit()
})

puEdit.addEventListener('blur', e => {
    e.preventDefault()
    calculerMontantEdit()
})

quantiteEdit.addEventListener('blur', e => {
    e.preventDefault()
    calculerMontantEdit()
})

function calculerMontantEdit () {
    if (nomEdit.value !== "" && !isNaN(parseFloat(puEdit.value)) && !isNaN(parseInt(quantiteEdit.value))){
        totalEdit.value = parseFloat(puEdit.value) * parseInt(quantiteEdit.value).toString()
    }
}


/**
 * Remplir la liste des pièces
 *
 * @param   {Array}  pieces    Tableau des pieces associé a un maintenance
 * @param   {String}  result    Identifiant du dom pour mettre le resultat
 * @param   {Boolean}  editable  Pour determiner si les élements son editables
 *
 * @return  {Array}            Retourne le tableau des pièces modifié
 */
function populatePieceList (pieces, result, editable = true) {
    //pieces = JSON.parse(pieces)
    let edit_result = document.querySelector(result)

    if (pieces === []) return new Object()

    pieces.forEach(piece => {
        let tr = document.createElement('tr')
        let action = "<button type='button' onclick='editPiece(this)' class='btn btn-primary mr-2'><i class='fa fa-edit'></i></button><button onclick='removePiece(this)' class='btn btn-danger'><i class='fa fa-minus'></i></button>"
        if (editable === false) action = "Aucun action"

        let tuple = `<td>${piece.designation}</td>
                    <td>${piece.fournisseur[0].nom}</td>
                    <td>${piece.fournisseur[0].contact}</td>
                    <td>${formatNumber(parseFloat(piece.pivot.pu), 2, "Ar")}</td>
                    <td>${formatNumber(parseInt(piece.pivot.quantite), 0)}</td>
                    <td>${formatNumber(parseFloat(piece.pivot.total), 2, "Ar")}</td>
                    <td class='d-inline-flex'>${action}</td>`

        tr.innerHTML = tuple
        edit_result.appendChild(tr)
    })

    let tmp = []

    pieces.forEach(piece => {
        tmp[piece.designation] = {
            nom: piece.designation,
            frs: piece.fournisseur[0].nom,
            contactFrs: piece.fournisseur[0].contact,
            pu: piece.pivot.pu,
            quantite: piece.pivot.quantite,
            total: piece.pivot.total,
        }
    });

    pieces = Object.assign({}, tmp)
    return pieces
}
