function fetchImage(event) {
    switch (event.target.textContent) {
        case "INE":
            imageType = 'ine';
            break;
        case "Firma":
            imageType = 'firm';
            break;
    }
    let apiRoute = document.getElementById('apiRoute').value;
    const params = new URLSearchParams({
        'idVolunteer': document.getElementById('idVolunteer').textContent,
        'image': imageType
    });
    fetch(`${apiRoute}?${params}`, {
        headers: {
            'Authorization': 'Bearer ' +  document.getElementById('jwt').value
        }}).then(response => {
                if (!response.ok || response.status != 200) {
                    throw new Error('Error de red: ' + response.status);
                }
                return response.blob();
            })
        .then(response => {
            // Supongamos que ya tienes un objeto Blob almacenado en la variable "miBlob"
            let url = URL.createObjectURL(response);

            // Obtener el elemento HTML "img"
            const img = document.getElementById('imgFile');

            // Asignar la URL generada al elemento "img"
            img.src = url;
            $('#modalCustom').modal();
            document.getElementById('modalTitle').textContent = event.target.textContent;
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No hay imagen relacionada para el voluntario'
            });
            document.getElementById('modalTitle').textContent = '';
        });
}

$(document).ready(function() {
    $('.btnResource').on('click', fetchImage);
});
