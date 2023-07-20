<?php

include 'conexion.php';
$pdo = new Conexion();

// Consultar un registro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = $pdo->prepare("SELECT * FROM tbl_usuarios WHERE usuario = :usuario AND clave = :clave");
	$sql->bindValue(':usuario', $_GET['usuario']);
	$sql->bindValue(':clave', $_GET['clave']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $cuenta = $sql->rowCount();
    echo $cuenta;
if ($cuenta) {
        header('HTTP 200 OK');
        echo json_encode($sql->fetchAll());
    }
else {
        echo "Usuario o Clave Incorrecta";
    }
exit;
} 

// Crear un registro
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO tbl_usuarios (usuario, clave) VALUES (:usuario, :clave)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuario', $_POST['usuario']); 
        $stmt->bindValue(':clave', $_POST['clave']); 
        $stmt->execute();
        $idPost = $pdo->lastInsertId();
        if ($idPost) { 
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
            
        }
        else echo "Usuario no Registrado";
        exit;
    } 

?>