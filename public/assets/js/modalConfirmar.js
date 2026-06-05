function confirmarEliminacion(event, url, mensaje) {

    //Evito que el enlace navegue al instante
    if (event) event.preventDefault();

    //Cogemos el modal y sus elementos internos
    var modalEl   = document.getElementById('modalConfirmar');
    var btnConfir = document.getElementById('modalConfirmarBtn');
    var pMensaje  = document.getElementById('modalConfirmarMensaje');

    //Actualizo el texto y la URL del botón "Sí, eliminar"
    if (mensaje) pMensaje.textContent = mensaje;
    btnConfir.setAttribute('href', url);

    //Abrimos el modal con la API de Bootstrap
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();

    //Devolvemos false 
    return false;
}
