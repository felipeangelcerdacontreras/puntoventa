<?php
	include 'conexion.php';

	$id_user = $_POST["id_user"];
	$user_user = $_POST["user_user"];
	
	$tipo_user = $_POST["tipo_user"];
	$nom_user = $_POST["nom_user"];
	$direc_user = $_POST["direc_user"];
	$tel_user = $_POST["tel_user"];
	$email_user = $_POST["email_user"];
	$sucursal = $_POST["sucursal"];

	if($id_user == "") {
		$pass_user = MD5($_POST["pass_user"]);
		$insertaDatosUser = mysqli_query($con, "Insert into datos_usuarios values(null, '$nom_user', '$direc_user', '$tel_user', '$email_user')");
		if(!$insertaDatosUser) {

			echo "No se ha podido guardar el usuario. ".mysqli_error($con);
		}
		else {
			$id_user = mysqli_insert_id($con);
			$insertaUser = mysqli_query($con, "Insert into usuarios values(null, '$id_user', '$user_user', '$pass_user', '$tipo_user', null, 1, 1, 1, 1)");
			if(!$insertaUser) {
				mysqli_query($con,"DELETE FROM datos_usuarios WHERE id_user = '$id_user'");
				echo "No se ha podido guardar el usuario. ".mysqli_error($con);
			}
			else {
				echo "Usuario insertado correctamente.";
			}
		}
	}
	else { 
		$sql_pass = "";
		$pass_user = $_POST["pass_user"];
        if (!empty($pass_user)) {
			$cript = MD5($_POST['pass_user']);
            $sql_pass = "pass='{$cript}',";
        }
		$sqlDtsUser = "Update datos_usuarios set nombre='$nom_user', direccion='$direc_user', telefono='$tel_user', correo='$email_user' where id_user=$id_user";
		$sqlUser = "Update usuarios set user='$user_user',{$sql_pass} tipo='$tipo_user' where id_user=$id_user";

		$actualizaDatosUser = mysqli_query($con, $sqlDtsUser);
		if(!$actualizaDatosUser)
			echo "No se pudieron actualizar los datos ".mysqli_error($con);
		else {
			$actualizaUser = mysqli_query($con, $sqlUser);
			if(!$actualizaUser)
				echo "No se pudo actualizar el usuario ".mysqli_error($con);
			else
				echo "Usuario actualizado correctamente.";
		}
	}
	mysqli_close($con);
?>
