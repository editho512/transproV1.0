
let addMaterielEdit = document.getElementById('addMaterielEdit')

let nomEdit = document.getElementById('nom-edit')
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
    let tuple = "<td>" + nomEdit.value + "</td><td>" + parseFloat(puEdit.value) + " Ar</td><td>" + parseFloat(quantiteEdit.value) + "</td><td>" + parseFloat(totalEdit.value) + " Ar</td><td class='d-inline-flex'><button onclick='editPiece(this)' class='btn btn-primary mr-2'><i class='fa fa-edit'></i></button><button onclick='removePiece(this)' class='btn btn-danger'><i class='fa fa-minus'></i></button></td>"

    if (pieces[nomEdit.value]) { alert('Cette piece existe déja dans la liste'); resetFields(); return; }

    tr.innerHTML = tuple
    resultEdit.appendChild(tr)

    let key = nomEdit.value

    pieces[key] = {
        nom: nomEdit.value,
        pu: puEdit.value,
        quantite: quantiteEdit.value,
        total: totalEdit.value
    }

    resetFieldsEdit()
})

function resetFieldsEdit () {
    nomEdit.value = null; puEdit.value = null; quantiteEdit.value = null; totalEdit.value = null;
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


function populatePieceList (pieces, result, editable = true) {
    pieces = JSON.parse(pieces)
    let edit_result = document.querySelector(result)

    if (pieces === null) return new Object()

    Object.entries(pieces).forEach(piece => {
        piece = piece[1]
        let tr = document.createElement('tr')

        $action = "<button type='button' onclick='editPiece(this)' class='btn btn-primary mr-2'><i class='fa fa-edit'></i></button><button onclick='removePiece(this)' class='btn btn-danger'><i class='fa fa-minus'></i></button>"

        if (editable === false) $action = "Aucune action"

        let tuple = "<td>" + piece.nom + "</td><td>" + parseFloat(piece.pu) + " Ar</td><td>" + parseFloat(piece.quantite) + "</td><td>" + parseFloat(piece.total) + " Ar</td><td class='d-inline-flex'>" + $action + "</td>"
        tr.innerHTML = tuple
        edit_result.appendChild(tr)
    })

    return pieces
}
