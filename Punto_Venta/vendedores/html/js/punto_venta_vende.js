var total = 0; //Variable para llevar el control del total
var totalFinal = 0; //Variable para llevar el control del total
var indArt = 0; //Variable que lleva el indice de los articulos agregados
var totalDev = 0; //Variable para llevar el control del total de la devolucion
/************************************** LOGIN **************************************/
function login() {
    var user = $("#vendedor_user").val();
    var pass = $("#vendedor_pass").val();

    $.ajax({
        data: "user="+user+"&pass="+pass,
        type: "POST",
        url: "controllers/login.php",
        success: function(data) {
            // alert(data);
            var datos = JSON.parse(data);
            if(!datos.success) {
                alert(datos.error);
                return;
            }
            alert("Bienvenido");
            window.location = datos.page;
        }
    });
}
function clientes(tipo_consulta) { //Trae todos los clientes existentes en la base de datos.
    $.ajax({
        data: "tipo_consulta="+tipo_consulta,
        type: "POST",
        url: "../../models/clientesRegistrados.php",
        success: function(data) {
            $('#divClientes').html(data);
            $('#tabla').DataTable({ responsive: true });
        }
    });
}

function cerrarSesion() {
    var confirmacion = confirm("¿Está seguro que desea cerrar sesión?");
    if (confirmacion) {
        $.ajax({
            data: "",
            type: "POST",
            url: "../controllers/cerrarSesion.php",
            success: function(data) {
                window.location = data;
            }
        });
    }
}
