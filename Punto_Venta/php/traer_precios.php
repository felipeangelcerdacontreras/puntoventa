<?php
include "./conn.php"; 
//recibe de la funcion guargassp

$id = $_POST['id'];

$sql=mysql_query("SELECT * FROM productos_venta WHERE IdProductosventa= $id ") or die(mysql_error());
while($row3=mysql_fetch_array($sql)){
    $precio_prodv=$row3['precio_prodv'];
    $precio_foraneo=$row3['precio_foraneo'];
    $precio_menudeo=$row3['precio_menudeo'];

    $extra1=$row3['extra1'];
    $extra2=$row3['extra2'];
    $extra3=$row3['extra3'];
    $extra4=$row3['extra4'];
    }
?>

      <label><b>Precios:</b>&nbsp;</label>
      <select name='precios_venta' id='precios_venta' class="form-control"> 
      <OPTION VALUE="<?=$precio_prodv;?>">Foraneo Mayoreo-<?php echo $precio_prodv;?></OPTION>
      <OPTION VALUE="<?=$precio_foraneo;?>">Local Medio Mayoreo-<?php echo $precio_foraneo;?></OPTION>
      <OPTION VALUE="<?=$precio_menudeo;?>">Menudeo-<?php echo $precio_menudeo;?></OPTION>

      <OPTION VALUE="<?=$extra1;?>">Alternativo 1-<?php echo $extra1;?></OPTION>
      <OPTION VALUE="<?=$extra2;?>">Alternativo 2-<?php echo $extra2;?></OPTION>
      <OPTION VALUE="<?=$extra3;?>">Alternativo 3-<?php echo $extra3;?></OPTION>
      <OPTION VALUE="<?=$extra4;?>">Alternativo 4-<?php echo $extra4;?></OPTION>
    </select>  
