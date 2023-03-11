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
        'idVolunteer': document.getElementById('idVolunteer'),
        'image': imageType
    });
    fetch(`${apiRoute}?${params}`, {
        headers: {
            'Authorization': 'Bearer ' +  document.getElementById('jwt').value
        }}).then(response => response.blob)
        .then(response => {
            console.log(response);
            if (!response.ok) {
                throw new Error('Error de red: ' + response.status);
            }
        })
        .catch(error => {
            console.error("error", error);
        });
}

$(document).ready(function() {
    $('.btn').on('click', fetchImage);
});
