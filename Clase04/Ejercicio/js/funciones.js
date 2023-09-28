"use strict";
var Funciones;
(function (Funciones) {
    //CREO UNA INSTANCIA DE XMLHTTPREQUEST
    let xhttp = new XMLHttpRequest();
    function AjaxPostJSON(accion) {
        let xhttp = new XMLHttpRequest();
        let legajo = document.getElementById('legajo').value;
        let nombre = document.getElementById('nombre').value;
        let apellido = document.getElementById('apellido').value;
        xhttp.open("POST", "./backend/nexo_poo.php");
        //INSTANCIO OBJETO FORMDATA
        let form = new FormData();
        //AGREGO PARAMETROS AL FORMDATA:
        form.append('accion', `${accion}`);
        form.append('legajo', legajo);
        form.append('nombre', nombre);
        form.append('apellido', apellido);
        //ENVIO DE LA PETICION CON LOS PARAMETROS FORMDATA
        xhttp.send(form);
        //FUNCION CALLBACK
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                alert(xhttp.responseText);
            }
        };
    }
    Funciones.AjaxPostJSON = AjaxPostJSON;
})(Funciones || (Funciones = {}));
//# sourceMappingURL=funciones.js.map