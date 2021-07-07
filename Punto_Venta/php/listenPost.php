<meta charset="utf-8"> 
<?php
	include 'conexion.php';

	if(isset($_POST["json"])){
		$json = $_POST["json"];
		$json = urldecode($json);
		$json = str_replace("\\", "", $json);
		$jsonencode = json_decode($json);
		$kilos = $jsonencode[0]->kilos;

		$insertaPeso = mysqli_query($con, "Insert into peso values(null, '$kilos')");
		if($insertaPeso) {
			echo "Se ha insertado el peso: ".$kilos;
		}
		else {
			echo "No se ha podido registrar peso en la base de datos ".mysqli_error($con);
		}
	}
	mysqli_close($con);
?>