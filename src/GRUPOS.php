<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

//========== INICIO TABLA GRUPOS ============
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM GRUPOS");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
}
//============= FIN TABLA ESTADIO ============


// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO GRUPOS
          (nombre_grupo)
          VALUES
          (:nombre_grupo)";
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
	$idGrupo = $_GET['idGrupo'];
  $statement = $dbConn->prepare("DELETE FROM GRUPOS where idGrupo=:idGrupo");
  $statement->bindValue(':idGrupo', $idGrupo);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}



//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>