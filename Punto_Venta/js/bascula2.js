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
        		$('#unidades').text(datos);

                if(unidad != "KG"){
                    var cantidad = $('#unds').val();
                }
                else {
                    var cantidad = $('#undades').val();
                }
        		
                if(precio != "") {
                    var total_art = precio * cantidad;
                    $('#totalArt').text("Importe: $" + total_art);
                }
        	}
        }
    });
}