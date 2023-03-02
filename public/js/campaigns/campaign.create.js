$(document).ready(function() {
    $("#img_campaign").fileinput({'showUpload':false, 'previewFileType':'any', 'language': 'es'});
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
    //Doc: https://github.com/apvarun/toastify-js/blob/master/README.mds
    /*Toastify({
        text: "This is a toast",
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        style: {
            background: "#424242",
        },
    }).showToast();
    */
});
