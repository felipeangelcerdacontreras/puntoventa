var total = 0; //Variable para llevar el control del total
var totalFinal = 0; //Variable para llevar el control del total
var indArt = 0; //Variable que lleva el indice de los articulos agregados
var totalDev = 0; //Variable para llevar el control del total de la devolucion
/************************************** LOGIN **************************************/
function login() {
    var user = $("#login_user").val();
    var pass = $("#login_pass").val();

    $.ajax({
        data: "user="+user+"&pass="+pass,
        type: "POST",
        url: "php/login.php",
        success: function(data) {
             //alert(data);
            var datos = JSON.parse(data);
            if(!datos.success) {
                alert(datos.error);
                return;
            }
            window.location = datos.page;
        }
    });
}

function cerrarSesion() {
    var confirmacion = confirm("¿Está seguro que desea cerrar sesión?");
    if (confirmacion) {
        $.ajax({
            data: "",
            type: "POST",
            url: "php/cerrarSesion.php",
            success: function(data) {
                window.location = data;
            }
        });
    }
}

