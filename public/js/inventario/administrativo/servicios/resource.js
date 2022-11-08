// Traer la funcion ver_recurso_servicio a este archivo

// Traer la funcion alta_servicio_recurso a este archivo

// Traer la funcion alta_servicio_recurso_2 a este archivo

// Redirige al menú INVENTARIO > RED METRO > LANSWITCH
function redirect_service_assignment() {
    const accept = $('#accept_btn');
    const cancel = $('#cancel_btn');
    const popup = $('#redirect_service_assignment')

    popup.modal('show');
    accept.off().on('click', () => window.location.href = getBaseURL() + 'ver/lanswitch');
    cancel.off().on('click', () => $('#type_equip').prop('selectedIndex', 0));
}