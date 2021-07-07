var timer = setInterval(verifica, 350);

function verifica() {
    var precio = $('#precio').val();
    var nom_articulo = $('#nombreArticulo').val();
    var unidad = $('#articulos').find('option[value="'+nom_articulo+'"]').attr('unidad');
    // if(precio != "") {
    //     alert("ptso todos");
    // }

    $.ajax({
        type: "POST",
        url: "php/datosBascula.php",
        success: function(data) {
            if(datos = JSON.parse(data)) {
                if(datos[0] != "  NEG.    ") { // con esta condicion se verifica si la bascula esta mandando negativo
                    console.log(datos);
                    $('#unidades').text(datos);
                    if(unidad != "KG"){
                        var cantidad = $('#unds').val();
                    }
                    else {
                        var cantidad = datos;
                    }
                    
                    if(precio != "") {
                        var total_art = precio * cantidad;
                        $('#totalArt').text("Importe: $" + total_art);
                    }
                }
                else {
                    //$('#unidades').text('0.000');
                    console.log('negativo');
                }
            }
        }
    });
}