<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    
      $sql = $dbConn->prepare("SELECT * FROM TIPO_PARTIDO");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO TIPO_PARTIDO
          (descripcion)
          VALUES
          (:descripcion)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$idTIPO_PARTIDO = $_GET['idTIPO_PARTIDO'];
  $statement = $dbConn->prepare("DELETE FROM TIPO_PARTIDO where idTIPO_PARTIDO=:idTIPO_PARTIDO");
  $statement->bindValue(':idTIPO_PARTIDO', $idTIPO_PARTIDO);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}



//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>