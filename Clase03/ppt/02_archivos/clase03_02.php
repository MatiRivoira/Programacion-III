<?php

$tipoEjemplo = isset($_POST["tipoEjemplo"]) ? (int) $_POST["tipoEjemplo"] : 0;


switch($tipoEjemplo)
{
	case 1:
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/miArchivo.txt", "r");

		//LEO EL ARCHIVO COMPLETO
		echo fread($ar, filesize("./archivos/miArchivo.txt"));

		//CIERRO EL ARCHIVO
		fclose($ar);

		break;

	case 2:
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/miArchivo.txt", "r");

		//LEO 5 BYTES DEL ARCHIVO (5 LETRAS)
		echo fread($ar, 5);

		//CIERRO EL ARCHIVO
		fclose($ar);

		break;

	case 3:
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/miArchivo.txt", "r");

		//LEO 1 LÍNEA DEL ARCHIVO
		echo fgets($ar);

		//CIERRO EL ARCHIVO
		fclose($ar);

		break;

	case 4:
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/miArchivo.txt", "r");

		//LEO LÍNEA POR LÍNEA DEL ARCHIVO 
		while( ! feof($ar))
		{
			echo fgets($ar);
		}

		//CIERRO EL ARCHIVO
		fclose($ar);

		break;

	case 5:
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/miArchivo.txt", "a");//A - append
		
		//ESCRIBO EN EL ARCHIVO
		$cant = fwrite($ar, "\n-Escribo en el archivo otra vez.");
		
		if($cant > 0)
		{
			echo "escritura EXITOSA";			
		}

		//CIERRO EL ARCHIVO
		fclose($ar);

		break;

	case 6:
		
		$path_origen = "./archivos/miArchivo.txt";
		$path_destino = "./archivos/miArchivo2.txt";
		
		//COPIO EN EL ARCHIVO
		$copio = copy($path_origen, $path_destino);
		
		if($copio)
		{
			echo "copia EXITOSA";			
		}
		else
		{
			echo "no se pudo COPIAR";
		}

		break;

	case 7:
		
		$path = "./archivos/miArchivo2.txt";
		
		//ELIMINO EL ARCHIVO
		$elimino = unlink($path);
		
		if($elimino)
		{
			echo "Se eliminó EXITOSAMENTE";			
		}
		else
		{
			echo "No se pudo ELIMINAR";
		}

		break;	
	
		
	case 8:

		echo file_get_contents("./archivos/miArchivo.txt");

		break;

	case 9:

		$cant = file_put_contents("./archivos/miArchivo.txt", "Se sobreescribe el archivo.");
		
		if($cant > 0)
		{
			echo "escritura EXITOSA";			
		}
		else
		{
			echo "No se pudo escribir";
		}

		break;

	case 10:

		$cant = file_put_contents("./archivos/miArchivo.txt", "\n-Escribo en el archivo otra vez.", FILE_APPEND);
		
		if($cant > 0)
		{
			echo "escritura EXITOSA";			
		}
		else
		{
			echo "No se pudo escribir";
		}

		break;
	
	default:
		echo "Sin ejemplo";
}