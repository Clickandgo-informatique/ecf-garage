window.onload = () => {

    const tblMarques = document.getElementById('tblMarques')

    tblMarques.addEventListener('click', e => {
        e.preventDefault
        if (e.target.id === "btn-supprimer-marque") {
            if (confirm("Etes vous sûr de vouloir effacer cette marque de véhicule ?.")) {
                const id = e.target.getAttribute('data-id')
                
                fetch(`/marques/supprimer/${id}`, {
                    method: 'DELETE'
                }).then((response)=>window.location.reload())
                .catch(error =>error.message)
            }
        }
    })
}