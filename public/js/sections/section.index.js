function fillTable(){
    let table = $('#table').DataTable();

    let apiRoute = document.getElementById('apiRoute').value;

    let stateId = document.getElementById('state_id').value;
    let queryParams = new URLSearchParams();
    queryParams.append("stateId", stateId);
    queryParams.append("page", table.page.info().page);

    fetch(`${apiRoute}?${queryParams}`,{
        type: "GET",
        headers: {
            "Authorization" : "Bearer" + document.getElementById('jwt').value
        },
    })
    .then(data => data.json())
    .then(data => {
        console.log(data);
        console.log(data.data);
        let table = $('#table').DataTable();
        table.clear().draw();
        table.rows.add(data.data);
        table.draw();
        table.page(data.current_page-1).draw('page');
    })
    .catch(error => console.error(error));
}

$(document).ready(function() {
    $('.select').select2({
        theme: "bootstrap4",
        placeholder: "Seleccione una opcion",
    });
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
            { "data": "id" },
            { "data": "section" },
            { "data": "state_id" },
            { "data": "municipality_id" },
            { "data": "federal_district_id" },
            { "data": "local_district_id" }
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
                d.stateId = document.getElementById('state_id').value;
                d.length = $('#table').DataTable().page.len();
                d.page = $('#table').DataTable().page() + 1;
                // Agrega tantos parámetros dinámicos como necesites
            }
        },
        "paging": true,
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        "pageLength": 10,
    });
    $('#state_id').on('select2:select', function(){
        let table = $('#table').DataTable();
        table.ajax.reload().draw();
    });
});
