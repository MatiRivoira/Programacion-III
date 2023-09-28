namespace Funciones
{
    //CREO UNA INSTANCIA DE XMLHTTPREQUEST
    let xhttp : XMLHttpRequest = new XMLHttpRequest();

    export function AjaxPostJSON(accion:string) : void 
    {
        
        let xhttp : XMLHttpRequest = new XMLHttpRequest();
        let legajo = (<HTMLInputElement>document.getElementById('legajo')).value;
        let nombre = (<HTMLInputElement>document.getElementById('nombre')).value;
        let apellido = (<HTMLInputElement>document.getElementById('apellido')).value;
        xhttp.open("POST", "./backend/nexo_poo.php");

        //INSTANCIO OBJETO FORMDATA
        let form : FormData = new FormData();

        //AGREGO PARAMETROS AL FORMDATA:
        form.append('accion', `${accion}`);
        form.append('legajo', legajo);
        form.append('nombre', nombre);
        form.append('apellido', apellido);
        
        //ENVIO DE LA PETICION CON LOS PARAMETROS FORMDATA
        xhttp.send(form);

        //FUNCION CALLBACK
        xhttp.onreadystatechange = () => 
        {
            if (xhttp.readyState == 4 && xhttp.status == 200) 
            {
                alert(xhttp.responseText);
            }
        };
    }
}