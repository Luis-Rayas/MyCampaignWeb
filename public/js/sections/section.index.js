
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('.select').select2({
        theme: "bootstrap4",
        placeholder: "Seleccione una opcion",
    });
    var table = $('#table').DataTable({
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
        table.ajax.reload().draw();
    });

    $('#table tbody').on('click', 'td', function() {
        var tr = $(this);
        var row = table.row(tr);
        var rowIdx = table.cell(this).index().row;
        var colIdx = table.cell(this).index().column;
        var colName = table.column(colIdx).header().innerText;
        var cellData = table.cell(rowIdx, colIdx).data();

        let apiRoute = null;
        switch(colName){
            case "Estado":
                apiRoute = "states";
                break;
            case "Municipio":
                apiRoute = "municipalities";
                break;
            case "Distrito Local":
                apiRoute = "local-districts";
                break;
            case "Distrito Federal":
                apiRoute = "federal-districts";
                break;
            default:
                return;
        }
        // Verificar si la fila ya tiene una fila hija y eliminarla
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.ajax({
                url: `/api/${apiRoute}/${cellData}`,
                method: 'GET',
                headers: {
                    "Authorization": "Bearer " + document.getElementById('jwt').value
                },
                success: function(data) {
                    console.log(data);
                    // Actualizar la tabla con la nueva información
                    /*var newRowData = new Object();
                    newRowData.id = data.id;
                    newRowData.name = data.name;
                    table.row($(this).closest('tr')).data(newRowData).draw();*/
                    // Construir el HTML de la fila hija con la información adicional
                    var html = '<div>' + data.name + '</div>';

                    // Añadir la fila hija a la fila principal
                    row.child(html).show();
                    tr.addClass('shown');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
