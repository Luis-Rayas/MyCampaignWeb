$(document).ready(function() {
    $('#table').DataTable({
        responsive: true,
        language: {
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'Sin registros',
            info: 'Mostrando pág _PAGE_ de _PAGES_',
            infoEmpty: 'Sin registros disponibles',
            infoFiltered: '(filtrado de _MAX_ total de registros)',
        },
    });
});
