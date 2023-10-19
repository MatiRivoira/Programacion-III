<?php

$opcion = $_POST['opcion'];

switch($opcion)
{
    case "conexion":

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root","");      
            echo "se conecto <br>";

        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }
     
    break;
    case "listar":
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
            $sql = $pdo->query("SELECT * from mi_tabla");
            
            if($sql != false)
            {
                $retorno = $sql->fetchAll();
                if($retorno != false)
                {                
                    foreach($retorno as $fila)
                    {
                        echo $fila[0]. " - " . $fila[1] . " - ". $fila[2]."\n";                      
                    }
                }
            }

        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }
    break;
    case "listar_fetchobject":
        try
        {
            require_once "./mi_tabla.php";

            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
            $sql = $pdo->query("SELECT * from mi_tabla");
            
            if($sql != false)
            {                                
                while($retorno = $sql->fetchObject("mi_tabla"))
                {
                    echo $retorno->toString();   
                }                                                               
            }

        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }
        break;

        case "listar_fetchobject_std":
            try
            {
                 
                $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
                $sql = $pdo->query("SELECT * from mi_tabla");
                
                if($sql != false)
                {                                
                    while($retorno = $sql->fetchObject())
                    {
                        var_dump($retorno);
                    }                                                               
                }
    
            }catch(PDOException $exc)
            {
                echo $exc->getMessage() . "<br>";
            }
            break;

    case "listar_prepare":

        $id = $_POST["id"];

        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
            $sql = $pdo->prepare("SELECT * from mi_tabla WHERE id = :id");
            $sql->bindParam(":id",$id, PDO::PARAM_INT);
            $sql->execute();
            $fila = $sql->fetch();

            if($fila != false)
            {                                           
            var_dump($fila);                                                                           
            }

        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }


    break;
    case "agregar":

        $cadena = $_POST["cadena"];
        $fecha = $_POST["fecha"];
        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
            $sql = $pdo->prepare("INSERT INTO `mi_tabla`(`cadena`, `fecha`) VALUES (:cadena,:fecha)");
            $sql->bindParam(":cadena",$cadena, PDO::PARAM_STR,20);
            $sql->bindParam(":fecha",$fecha, PDO::PARAM_STR);

            if($sql->execute()){
                echo "todo ok";
            }else{echo "todo no ok";}
               
        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }
    break;
    case "modificar":

        $id = $_POST["id"];
        $cadena = $_POST["cadena"];
        $fecha = $_POST["fecha"];
        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
            $sql = $pdo->prepare("UPDATE `mi_tabla` SET `cadena`= :cadena,`fecha`= :fecha WHERE id = :id");
            $sql->bindParam(":id",$id, PDO::PARAM_INT);
            $sql->bindParam(":cadena",$cadena, PDO::PARAM_STR,20);
            $sql->bindParam(":fecha",$fecha, PDO::PARAM_STR);

            if($sql->execute()){
                echo "todo ok";
            }else{echo "todo no ok";}
               
        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }



    break;

    case "eliminar":
        $id = $_POST["id"];

        try
        {        
            $pdo = new PDO("mysql:host=localhost;dbname=mi_base", "root",""); 
            $sql = $pdo->prepare("DELETE FROM `mi_tabla` WHERE id = :id");
            $sql->bindParam(":id",$id, PDO::PARAM_INT);

            if($sql->execute()){
                echo "todo ok";
            }else{echo "todo no ok";}
               
        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }
    break;
}