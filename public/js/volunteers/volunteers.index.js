function goTo(idVolunteer) {
    window.location.href = `./volunteers/${idVolunteer}`;
}

$(document).ready(function() {
    $('#table').DataTable({
        responsive: true,
        ordering: false,
        language: {
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'Sin registros',
            info: 'Mostrando pág _PAGE_ de _PAGES_',
            infoEmpty: 'Sin registros disponibles',
            infoFiltered: '(filtrado de _MAX_ total de registros)',
        },
        "columns": [
            { "data": "full_name" },
            { "data": "email" },
            { "data": "phone" },
            { "data": "volunteer_type" },
            { "data": "notes" },
            { "data": "id" }
        ],
        columnDefs: [
            {
                targets: -1, // Última columna
                render: function(data, type, row, meta) {
                    console.log(data);
                    return `<button onclick="goTo(${data})" class="btn btn-success"><i class="fa-solid fa-eye"></i></button>`;
                }
            }
        ],
        //API
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": document.getElementById('apiRoute').value,
            "type": "GET",
            "headers": {
                "Authorization": "Bearer " + document.getElementById('jwt').value
            },
            "data": function ( d ) {
                d.length = $('#table').DataTable().page.len();
                d.page = $('#table').DataTable().page() + 1;
                // Agrega tantos parámetros dinámicos como necesites
            }
        },
        "paging": true,
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        "pageLength": 10,
    });
});
