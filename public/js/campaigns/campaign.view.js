$(document).ready(function () {
    $('#deleteForm').on('submit', (event) => {
        event.preventDefault();
        swal.fire({
            title: '¿Estás seguro?',
            html: 'Esto significa que <strong>no se podrán ingresar mas voluntarios a la campaña</strong><br/>' +
                'Para confirmar, ingrese el nombre de la campaña en el cuadro de texto a continuación <br/>' +
                '<strong>\"' + $('#name').val() + '\"</strong>' +
                '<br/><input type="text" id="confirmacion-input" class="swal2-input">',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                return !value && '¡Debes escribir una frase de confirmación!';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var confirmacion = $('#confirmacion-input').val();
                if (confirmacion == $('#name').val().trim()) {
                    $('#deleteForm')[0].submit();
                } else {
                    swal.fire({
                        title: 'Error',
                        text: 'La frase de confirmación no es correcta.',
                        icon: 'error'
                    });
                    event.preventDefault();
                }
            }
        });
        event.preventDefault();
    });
});
