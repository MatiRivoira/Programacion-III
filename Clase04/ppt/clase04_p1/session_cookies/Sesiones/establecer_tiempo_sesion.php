<?php
session_start();
 
    $inactivo = 15;//expresado en segundos
 
    if(isset($_SESSION['tiempo'])) {
		$vida_session = time() - $_SESSION['tiempo'];
        if($vida_session > $inactivo)
        {
            session_destroy();
            header("location: ../index.html"); 
        }
		echo "Todavía faltan ".($inactivo - $vida_session)." segundos";
    }
	else{
		$ahora = time();
		echo "Variable de sesión NO establecida...<br/>Se establece en ".$ahora;
		$_SESSION['tiempo'] = $ahora;
	}
?>