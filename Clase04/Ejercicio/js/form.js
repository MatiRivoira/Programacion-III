document.addEventListener('DOMContentLoaded', function () {
    const legajoInput = document.getElementById('legajo');
    const boton = document.getElementById('botonPDF');

    legajoInput.addEventListener('input', validarCampos);

    function validarCampos() {
        if (legajoInput.value.trim() !== '') {
            boton.removeAttribute('disabled');
        } else {
            boton.setAttribute('disabled', 'true');
        }
    }
});